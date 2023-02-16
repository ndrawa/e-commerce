<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use App\Models\Schema;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('landing-page.home');
    }

    public function profile()
    {
        return view('landing-page.profile');
    }
}
