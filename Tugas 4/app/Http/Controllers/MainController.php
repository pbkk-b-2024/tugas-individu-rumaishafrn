<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
    //
    public function index()
    {
        return view('home');
    }

    public function login()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            session(['api_token' => Auth::user()->createToken('Apotek')->plainTextToken]);
            return redirect()->route('home')->with('success', 'Kamu berhasil login');
        }

        return back()->with('error', 'Login gagal, silahkan cek email dan password kamu')
            ->withInput($request->only('email'));
    }

    public function register()
    {
        return view('register');
    }

    public function doRegister(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed'
            ],
            [
                'email.unique' => 'Email sudah terdaftar',
                'password.confirmed' => 'Password tidak cocok'
            ]
        );

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silahkan login');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login')->with('success', 'Kamu berhasil logout');
    }

    public function apiScheme()
    {
        return view('api-scheme');
    }
}
