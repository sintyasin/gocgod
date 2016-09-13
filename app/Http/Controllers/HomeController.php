<?php

namespace App\Http\Controllers;

use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Faq;
use Auth;
use App\Banner;
use App\AboutUs;
use App\Province;

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
    //---------------- HOME -----------------
    public function index(Request $request)
    {
        $data['contact'] = AboutUs::first();
        $data['query'] = Banner::all();
        $data['province'] = Province::orderBy('province_name', 'asc')->get();

        if($request->wantsJson())
        {
            $response = array(
                'type' => 'OK-CONTACT',
                'contact' => $data['contact'],
                'province' => $data['province']);
            return Response::json(compact('response'));
        }

        return view('page.home', $data);
    }

    //---------------- FAQ -----------------
    public function faq_question(Request $request)
    {
        $data['contact'] = AboutUs::first();

        return view('page.faq', $data);
    }

    public function faq_data(Request $request)
    {
        $data['query_faq'] = faq::all();
        if($request->wantsJson())
        {
            $response = array(
                'type' => 'OK-FAQ',
                'data' => $data['query_faq']);
            return Response::json(compact('response'));
        }
        return view('page.faq_data', $data);
    }
}
