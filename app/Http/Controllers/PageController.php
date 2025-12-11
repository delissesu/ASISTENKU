<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // tampilin halaman depan website
    public function index()
    {
        return view('pages.landing');
    }

    // tampilin halaman login/register
    public function auth()
    {
        return view('pages.auth');
    }
}
