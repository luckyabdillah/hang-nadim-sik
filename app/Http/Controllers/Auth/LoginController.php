<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $remember = $request->remember_me ? true : false;
        if (Auth::attempt($credentials, $remember)) {
            dd('logged in');
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        dd('wrong email / password');
        return redirect('/login')->withInput()->with('failed', 'Wrong email/password!');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
