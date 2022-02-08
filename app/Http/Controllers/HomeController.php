<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Pages;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


       public function show($slug)
    {
       $page = pages::whereSlug($slug)->first();
        return view('pages/index',['pagedata'=>$page]);
    }
}
