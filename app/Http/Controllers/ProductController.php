<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Product;
use App\ProductCategory;
use App\NameProduct;

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
    	$data['query'] = Product::where('varian_id', $id)->first();
        $data['queryCategory'] = ProductCategory::find($data['query']->category_id);

        return view('page.menu_detail', $data);
    }
}
