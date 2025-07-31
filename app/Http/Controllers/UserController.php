<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
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
