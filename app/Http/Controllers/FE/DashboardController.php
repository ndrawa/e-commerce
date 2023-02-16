<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $roles = Role::all()->except('name');
        return view('oa.dashboard.index', [
            'roles' => $roles,
        ]);
    }

    public function activity()
    {
        return view('oa.dashboard.activity');
    }
}
