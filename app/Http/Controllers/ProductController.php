<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Product;
use App\ProductCategory;

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
    	$data['query'] = Product::find($id);

    	return view('testing.productDetail', $data);
    }
}
