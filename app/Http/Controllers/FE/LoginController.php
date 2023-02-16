<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        // dd(session()->all());
        if (session()->get('login')) {
            return redirect(url('/nde/inbox'));
        } else {
            return redirect(url('login'));
        }
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }
}
