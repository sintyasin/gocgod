<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Product;
use App\ProductCategory;
use App\NameProduct;
use App\Testimonial;
use App\Member;

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
        $data['query_testimonial'] = Testimonial::where('varian_id', $id)->get();
    	$data['query'] = Product::where('varian_id', $id)->first();
        $data['queryCategory'] = ProductCategory::find($data['query']->category_id);

        return view('page.menu_detail', $data);
    }

    public function getMenuSample()
    {
        $data['query'] = Product::all();
        
        return view('page.productsample', $data);
    }

    public function giveTestimonial(array $data_testimonial)
    {
        return Testimonial::create([
            'id' => $data_testimonial['id'],
            'varian_id' => $data_testimonial['varian_id'],
            'testimonial' => $data_testimonial['testimonial'],
            'approval' => $data_testimonial[1],
        ]);
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

        return view('page.checkout', $data);
    }
}
