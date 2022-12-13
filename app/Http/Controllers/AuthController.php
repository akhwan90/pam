<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function doLogin()
    {
        $credentials = request()->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->with('notif', '<div class="alert alert-danger">Terjadi kesalahan login</div>')->onlyInput('email');
    }

    public function dashboard()
    {
        $data['menuAktif'] = "Home";
        return view('pages/dashboard', $data);
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    }
}
