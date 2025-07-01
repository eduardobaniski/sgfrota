<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        if (auth()->attempt(['name'=>$request['name'], 'password'=>$request['password']])) {
            $request->session()->regenerate();
        }
        
        return redirect('/');
    }
}
