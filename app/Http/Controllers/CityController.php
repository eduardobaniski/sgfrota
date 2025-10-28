<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100], true) ? $perPage : 10;

        $cidades = City::with('state')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhereHas('state', function ($qState) use ($q) {
                            $qState->where('name', 'like', "%{$q}%")
                                   ->orWhere('abbr', 'like', "%{$q}%");
                        });
                });
            })
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.gerenciar.cidade.index', [
            'cidades' => $cidades,
            'q' => $q,
            'perPage' => $perPage,
        ]);
    }

    public function create()
    {
        $estados = State::orderBy('name')->pluck('name', 'id');
        return view('admin.cadastro.cidade', ['estados' => $estados]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cidade' => 'required|string|max:64',
            'state_id' => 'required|exists:states,id',
        ]);

        $duplicata = City::whereRaw('LOWER(name) = ?', [strtolower($data['cidade'])])
            ->where('state_id', $data['state_id'])
            ->exists();

        if ($duplicata) {
            return redirect('gerenciar/cidade')->with('error', 'Esta cidade já existe para este estado!');
        }

        City::create([
            'name' => $data['cidade'],
            'state_id' => $data['state_id'],
        ]);

        return redirect('gerenciar/cidade')->with('success', 'Cidade cadastrada com sucesso!');
    }

    public function edit(City $cidade)
    {
        $estados = State::orderBy('name')->get();
        return view('admin.gerenciar.cidade.edit', ['cidade' => $cidade, 'estados' => $estados]);
    }

    public function update(Request $request, City $cidade)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:64',
            'state_id' => 'required|exists:states,id',
        ]);

        $duplicata = City::whereRaw('LOWER(name) = ?', [strtolower($dados['nome'])])
            ->where('state_id', $request->input('state_id'))
            ->where('id', '!=', $cidade->id)
            ->exists();

        if ($duplicata) {
            return redirect()->route('admin.gerenciar.cidade.index')->with('error', 'Esta cidade já está registada para este estado.');
        }

        $cidade->update([
            'name' => $dados['nome'],
            'state_id' => $request->input('state_id'),
        ]);

        return redirect()->route('admin.gerenciar.cidade.index')->with('success', 'Cidade atualizada com sucesso!');
    }

    public function destroy(City $cidade)
    {
        $cidade->delete();
        return redirect()->route('admin.gerenciar.cidade.index')->with('success', 'Cidade apagada com sucesso!');
    }
}
