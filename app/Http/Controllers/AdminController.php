<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Yajra\Datatables\Datatables;

use DB;
use App\Product;
use App\ProductCategory;
use App\User;
use App\City;

class AdminController extends Controller
{
  public function showAgentList()
  {
      $data['active'] = "agentList";

      return view('page.admin_agent', $data);
  }

  public function getAgentList()
  {
      $data['query'] = User::leftJoin('master__city', 'master__member.city_id', '=', 'master__city.city_id')
                            ->where('status_user', 0)
                            ->get(['name', 'address', 'master__member.city_id', 'date_of_birth', 'email', 'phone', 'status_user', 'verification', 'balance', 'bank_account','city_name']);
        
      return Datatables::of($data['query'])
      ->make(true);
  }

	public function showCustomerList()
	{
		  $data['active'] = "memberList";

      return view('page.admin_customer', $data);
	}

	public function getCustomerList()
	{
      $data['query'] = User::leftJoin('master__city', 'master__member.city_id', '=', 'master__city.city_id')
                            ->where('status_user', 1)
                            ->get(['name', 'address', 'master__member.city_id', 'date_of_birth', 'email', 'phone', 'status_user', 'verification', 'balance', 'bank_account','city_name']);
        
  		return Datatables::of($data['query'])
      ->make(true);
	}

    public function showProductList()
    {
        $data['query'] = Product::with(array('category'=>function($query){
            $query->select('category_id','category_name');
        }))->get(['category_id']);
        
    	$data['active'] = "productList";
        return view('page.admin_product', $data);
    }

   	public function getProductList()
   	{
   		$data['query'] = Product::get(['category_id', 'varian_name', 'price', 'qty', 'picture', 'weight', 'description']);
   		
        return Datatables::of($data['query'])
        ->addColumn('actions', 'action here')
        ->make(true);
   	}
}
