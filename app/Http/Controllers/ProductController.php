<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ProductModel;

class ProductController extends Controller
{
    public function getMenu()
    {
    	$data['query'] = ProductModel::all();

    	return view('page.productMenu', $data);
    }

    public function getMenuDetail($id)
    {
    	$data['query'] = ProductModel::find($id);

    	return view('page.productDetail', $data);
    }
}
