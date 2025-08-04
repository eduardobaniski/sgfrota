<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Busca todos os utilizadores, exceto o que está autenticado, e pagina o resultado
        $users = User::paginate(10);

        return view('admin.gerenciar.user.index', ['users' => $users]);
    }

    /**
     * Mostra o formulário para editar um utilizador existente.
     */
    public function edit(User $user)
    {
        // O Laravel já encontra o utilizador pelo ID.
        return view('admin.gerenciar.user.edit', ['user' => $user]);
    }

    /**
     * Atualiza um utilizador no banco de dados.
     */
    public function update(Request $request, User $user)
    {

        // Atualiza os dados básicos
        $user->username = $request['username'];
        $user->isAdmin = $request->has('isAdmin');

        // Verifica se uma nova palavra-passe foi fornecida
        if ($request->filled('password')) {
            $user->password = Hash::make($request['password']);
        }

        $user->save();

        return redirect()->route('admin.gerenciar.user.index')->with('success', 'Utilizador atualizado com sucesso!');
    }

    /**
     * Remove um utilizador do banco de dados.
     */
    public function destroy(User $user)
    {
        // Medida de segurança para impedir que um utilizador se apague a si mesmo
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.gerenciar.user.index')->with('error', 'Não pode apagar a sua própria conta!');
        }

        $user->delete();
        
        return redirect()->route('admin.gerenciar.user.index')->with('success', 'Utilizador apagado com sucesso!');
    }


    public function create()
    {
        return view('admin.cadastro.user');
    }

    public function store(Request $request)
    {
        $dados = [
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ];

        if (User::where('username', $request->username)->first()) {
            return redirect('cadastro')->with('error', 'Este usuário já existe!');
        }
        User::create($dados);
        return redirect()->route('cadastro.index')->with('success', 'Usuário ' . $request->username . ' cadastrado com sucesso!');
    }

    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (auth()->attempt(['username'=>$request['username'], 'password'=>$request['password']])) {
            $request->session()->regenerate();
        }
        if (Auth::user()->isAdmin) {
            return redirect('/adminPanel');
        }
        
        return redirect('/dashboard');

    }


    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();

        return redirect('/');
    }
}
