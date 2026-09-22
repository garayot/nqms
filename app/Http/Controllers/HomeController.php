<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }

    public function links()
    {
        return view('pages.links');
    }

    public function organization()
    {
        return view('pages.organization');
    }
}
