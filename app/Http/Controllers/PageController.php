<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('pages.landing');
    }

    public function auth()
    {
        return view('pages.auth');
    }
}
