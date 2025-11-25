<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('landing-page');
    }

    public function auth()
    {
        return view('auth-page');
    }
}
