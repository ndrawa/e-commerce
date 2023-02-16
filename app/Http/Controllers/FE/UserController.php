<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Users::find(Auth::user()->id);
        return view('oa.user.index', [
            'user' => $user,
        ] );
    }
}
