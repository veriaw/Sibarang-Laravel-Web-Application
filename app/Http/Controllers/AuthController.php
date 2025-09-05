<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
       $request->validate([
           'email' => 'required|email',
           'password' => 'required',
       ]);
       if(Auth::attempt($request->only('email', 'password'), $request->remember)){
           return redirect('/dashboard');
       }
       return back()->with('failed', 'Email atau password salah');
    }

    public function register(Request $request)
    {
        $allowedCredentials = [331512, 331513, 331514, 331515, 331516];
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|confirmed',
            'credentialid' => 'required',
        ]);
        // Cek credentialid
        if (!in_array($request->credentialid, $allowedCredentials)) {
            return back()->with('failed', 'Credential ID tidak valid.');
        }

        // Hanya masukkan name, email, password ke create
        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        // ...lanjutkan proses lain (misal login otomatis, redirect, dsb)
        return redirect('/login')->with('success', 'Registrasi berhasil!');
    }

    public function logout()
    {
        Auth::logout(Auth::user());
        return redirect('/login');
    }
}
