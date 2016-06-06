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

class ProductController extends Controller
{
    public function getMenu()
    {
    	$data['query'] = Product::all();
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
        $data['query'] = Product::all();
        
        return view('page.productsample', $data);
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
