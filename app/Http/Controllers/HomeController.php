<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Faq;
use Auth;
use App\Banner;
use App\AboutUs;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*
    public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['contact'] = AboutUs::first();
        $data['query'] = Banner::all();

        return view('page.home', $data);
    }

    public function faq_question()
    {
        $data['contact'] = AboutUs::first();
        $data['query_faq'] = faq::all();
        return view('page.faq', $data);
    }
}
