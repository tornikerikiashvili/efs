<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    
    public function argonIndex()
    {
        return view('argon.dashboard');
    }
    // public function index()
    // {
    //     return view('homepage');
    // }
}
