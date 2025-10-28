<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100], true) ? $perPage : 10;

        $estados = State::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('abbr', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.gerenciar.estado.index', [
            'estados' => $estados,
            'q' => $q,
            'perPage' => $perPage,
        ]);
    }

    public function create()
    {
        return view('admin.cadastro.estado');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:64|unique:states,name',
            'abbr' => 'required|string|size:2|unique:states,abbr',
        ]);

        State::create($data);

        return redirect('gerenciar/estado')->with('success', 'Estado cadastrado com sucesso!');
    }

    public function edit(State $estado)
    {
        return view('admin.gerenciar.estado.edit', ['estado' => $estado]);
    }

    public function update(Request $request, State $estado)
    {
        $data = $request->validate([
            'name' => 'required|string|max:64|unique:states,name,' . $estado->id,
            'abbr' => 'required|string|size:2|unique:states,abbr,' . $estado->id,
        ]);

        $estado->update($data);

        return redirect()->route('admin.gerenciar.estado.index')->with('success', 'Estado atualizado com sucesso!');
    }

    public function destroy(State $estado)
    {
        $estado->delete();
        return redirect()->route('admin.gerenciar.estado.index')->with('success', 'Estado apagado com sucesso!');
    }
}
