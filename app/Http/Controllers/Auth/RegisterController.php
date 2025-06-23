<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistrationRequest;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255',
            'vendor_name' => 'required|min:3|max:255',
            'email' => 'required|email:rfc,dns|max:255|lowercase|unique:registration_requests,email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        RegistrationRequest::create($validatedData);

        return redirect('/register/info')->with('registration-success', 'Pendaftaran berhasil dikirim');
    }

    public function info()
    {
        if (!session()->has('registration-success')) {
            return redirect('/');
        }

        $message = session('registration-success');
        return view('auth.info', compact('message'));
    }
}
