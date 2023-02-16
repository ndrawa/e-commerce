<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return view('oa.admin.index');
    }
}
