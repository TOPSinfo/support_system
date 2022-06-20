<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class adminLoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        return view("admin.login");
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = array(
            'email' => $request->email,
            'password' => $request->password
        );

        if (Auth::guard('support')->attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('support')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('main');
    }
}
