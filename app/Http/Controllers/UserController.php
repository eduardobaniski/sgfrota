<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        return view('cadastro.user');
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
