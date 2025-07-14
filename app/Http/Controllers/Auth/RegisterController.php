<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistrationRequest;
use App\Models\User;
use App\Models\Vendor;

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
            'email' => 'required|email:rfc,dns|max:255|lowercase|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'user_type' => 'external',
        ]);

        Vendor::create([
            'user_id' => $user->id,
            'legal_name' => $validatedData['vendor_name'],
        ]);

        return redirect('/login')->with('success', 'Pendaftaran berhasil');
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
