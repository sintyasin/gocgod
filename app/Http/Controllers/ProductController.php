<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Cart;
use Auth;
use App\Http\Requests;
use App\Product;
use App\ProductCategory;
use App\NameProduct;
use App\ProductTestimonial;
use App\Member;
use App\TransactionController;
use App\SampleDetail;
use App\SampleRequest;
use App\AboutUs;

class ProductController extends Controller
{
    public function getMenu()
    {
        $data['contact'] = AboutUs::first();
    	$data['query'] = Product::paginate(12);
        $i = 0;
        //masukkin data kategori ke array
        foreach($data['query'] as $tmp)
        {
            $data['queryCategory'][$i] = ProductCategory::find($tmp->category_id);
            $i++;
        }
        
    	return view('page.menu', $data);
    }

    public function getMenuDetail($id)
    {
        $data['contact'] = AboutUs::first();
        $data['query_testimonial'] = ProductTestimonial::where('varian_id', $id)
                                                        ->where('approval', 1)
                                                        ->get();
    	$data['query'] = Product::where('varian_id', $id)->first();
        $data['queryCategory'] = ProductCategory::find($data['query']->category_id);
        $i = 0;
        foreach($data['query_testimonial'] as $tmp)
        {
            $data['query_member'][$i] = Member::find($tmp->id);
            $i++;
        }

        return view('page.menu_detail', $data);
    }

    public function getMenuSample()
    {
        $data['contact'] = AboutUs::first();
        $data['query'] = Product::all();
        
        return view('page.productsample', $data);
    }

    public function productSample($id)
    {
        $data['contact'] = AboutUs::first();
        $data['request_data'] = SampleRequest::where('request_id', $id)->first();
        //dd($data['request_data']);
        $data['query'] = Product::all();

        return view('page.productsample_1', $data);
    }

    public function productsampledata(Request $request)
    {
        $v = Validator::make($request->all(),[
            'product' => 'required|numeric',
            'qty' => 'required|numeric',
            ]);

        if ($v->fails())
        {
            return redirect('productsample/'.$request->id)->withErrors($v->errors())->withInput();
        }

        $input = $request->all();

        $request_id = filter_var($input['id'], FILTER_SANITIZE_STRING);
        $varian_id = filter_var($input['product'], FILTER_SANITIZE_STRING);
        $quantity = filter_var($input['qty'], FILTER_SANITIZE_STRING);

        $sample = new SampleDetail;
        $sample->request_id = $request_id;
        $sample->varian_id = $varian_id;
        $sample->quantity = $quantity;
        $sample->save();

        return redirect('/home');
    }

    public function eventsample(Request $request)
    {
        $v = Validator::make($request->all(),[
            'event_name' => 'required|max:100',
            'event_date' => 'required|max:10',
            'event_venue' => 'required|max:100',
            'event_description' => 'required|max:1000',
            'request_date' => 'required|max:10',
            ]);

        if ($v->fails())
        {
            return redirect('productsample')->withErrors($v->errors())->withInput();
        }

        $input = $request->all();

        $id = Auth::user()->id;
        $event_name = filter_var($input['event_name'], FILTER_SANITIZE_STRING);
        $event_date = filter_var($input['event_date'], FILTER_SANITIZE_STRING);
        $event_venue = filter_var($input['event_venue'], FILTER_SANITIZE_STRING);
        $event_description = filter_var($input['event_description'], FILTER_SANITIZE_STRING);
        $request_date = filter_var($input['request_date'], FILTER_SANITIZE_STRING);

        $event = new SampleRequest;
        $event->agent_id = $id;
        $event->event_name = $event_name;
        $event->event_date = $event_date;
        $event->event_venue = $event_venue;
        $event->event_description = $event_description;
        $event->request_date = $request_date;
        $event->save();

        return redirect('/productsample/'.$event->request_id);
    }

    public function giveTestimonial(Request $data_testimonial, $idd)
    {
        $v = Validator::make($data_testimonial->all(),[
            'testimonial'   => 'required|max:500',
            ]);

        if ($v->fails())
        {
            return redirect('/menu_detail/'.$idd)->withErrors($v->errors())->withInput();
        }    

        $input = $data_testimonial->all();

        $id = Auth::user()->id;
        $varian_id = $idd;
        $testimonial = filter_var($input['testimonial'], FILTER_SANITIZE_STRING);

        $testi = new ProductTestimonial;
        $testi->id = $id;
        $testi->varian_id = $varian_id;
        $testi->testimonial = $testimonial;
        $testi->save();

        return redirect('/menu_detail/'.$idd);
    }

    public function getAllMenu()
    {
        $data['contact'] = AboutUs::first();
        $data['query_menu'] = Product::all();
        $i = 0;
        //masukkin data kategori ke array
        foreach($data['query_menu'] as $tmp)
        {
            $data['queryCategory'][$i] = ProductCategory::find($tmp->category_id);
            $i++;
        }

        // //musti dijoin 3 table
        // foreach($data['cart_content'] as $temp)
        // {
        //     $data['query_content'][$j] = ProductCategory::find($temp->);
        // }
         
        // dd($data['cart_content']);

        return view('page.checkout_subcriber', $data);
    }


}
