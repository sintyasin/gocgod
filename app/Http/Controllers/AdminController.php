<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Yajra\Datatables\Datatables;

use App\Product;

class AdminController extends Controller
{
    public function showProductList()
    {
    	$data['active'] = "productList";
        return view('page.admin_product', $data);
    }

   	public function getProductList()
   	{
   		$data['query'] = Product::select(['varian_name', 'price', 'qty']);
 
        return Datatables::of($data['query'])->make(true);
   	}
}
