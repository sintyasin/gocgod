<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Requests;
//use Request;
use Validator;
use Session;
use Auth;
use Yajra\Datatables\Datatables;
//use ValidatesRequests;

use DB;
use Hash;
use App\Product;
use App\ProductCategory;
use App\User;
use App\City;
use App\Faq;
use App\ProductTestimonial;
use App\AgentRating;
use App\AboutUs;
use App\SampleRequest;
use App\SampleDetail;
use App\CutOffDate;
use App\TxOrder;
use App\TxOrderDetail;
use App\TxShipDetail;
use App\TxShip;
use App\Admin;
use App\AdminInfo;

class SampleDetailData
{
  public $name;
  public $quantity;
}

class ProductData
{
  public $name;
  public $quantity;
  public $price;
}

class AdminController extends Controller
{
  public function getConfirmTx()
  {
    $today = new \DateTime(NULL);
    date_add($today,date_interval_create_from_date_string("-8 days"));
    $date = date_format($today,"Y-m-d");
    //dd($date);
    //WHERE status_confirmed = 0 AND order_date < ?', [$date]);
    /*DB::update('UPDATE transaction__order 
                SET status_confirmed = 1 
                WHERE status_confirmed = 0 AND
                (SELECT order_id, shipping_id
                  FROM transaction__shipping s
                  WHERE s.order_id = order_id AND
                  (SELECT shipping_id
                    FROM transaction__shipping_detail d
                    WHERE d.shipping_id = s.shipping_id)) ');*/
    DB::update('UPDATE transaction__order
                SET status_confirmed = 1 
                WHERE status_confirmed = 0 AND ? > 
                (SELECT date_shipping
                  FROM transaction__shipping s
                  LEFT JOIN transaction__shipping_detail d
                  USING(shipping_id)
                  WHERE s.order_id = transaction__order.order_id)', [$date]);
  }

  public function getBannerList()
  {
    $data['active'] = 'bannerList';
  }


  //NEW ADMIN
  public function getAdminList()
  {
    $data['active'] = 'adminList';

    return view('page.admin_admin_list', $data);
  }

  public function getAdminData()
  {
    $data['query'] = Admin::leftJoin('master__admin_information as i', 'i.admin_id', '=', 'id')
                            ->get(['id', 'name', 'email', 'phone', 'super', 'information']);

    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getAddAdmin()
  {
    $data['active'] = 'addAdmin';
    $data['city'] = City::all();

    return view('page.admin_add_admin', $data);
  }

  public function postAddAdmin(Request $request)
  {
    $v = Validator::make($request->all(), [
        'name' => 'required|max:100',
        'password' => 'required|min:3|confirmed',
        'dob' => 'required',
        'city' => 'required|numeric',
        'address' => 'required|max:500',
        'phone' => 'numeric',
        'email' => 'required|email|unique:master__admin,email',
        'super' => 'required|digits_between:0,1|integer'
    ]);

    if ($v->fails())
    {
        return redirect('/admin/add')->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $name = filter_var($input['name'], FILTER_SANITIZE_STRING);
    $pass = Hash::make($input['password']);
    $dob = filter_var($input['dob'], FILTER_SANITIZE_STRING);
    $city = filter_var($input['city'], FILTER_SANITIZE_STRING);
    $address = filter_var($input['address'], FILTER_SANITIZE_STRING);
    $phone = filter_var($input['phone'], FILTER_SANITIZE_STRING);
    $super = filter_var($input['super'], FILTER_SANITIZE_STRING);
    $email = filter_var($input['email'], FILTER_SANITIZE_STRING);
    $info = filter_var($input['info'], FILTER_SANITIZE_STRING);

    //kalo new city, berarti insert dulu city barunya
    if($city == 0)
    {
      $newcity = filter_var($input['newcity'], FILTER_SANITIZE_STRING);
      
      $data = new City;
      $data->city_name = $newcity;
      $data->save();
    }

    $admin = new Admin();
    $admin->name = $name;
    $admin->password = $pass;
    $admin->email = $email;
    $admin->date_of_birth = $dob;
    $admin->address = $address;
    $admin->phone = $phone;
    $admin->super = $super;
    if($city == 0)
        $admin->city_id = $data->city_id;
    else
        $admin->city_id = $city;
    $admin->save();

    $data = new AdminInfo();
    $data->information = $info;
    $data->admin_id = $admin->id;
    $data->save();

    Session::flash('success', 1);
    return redirect('/admin/add');
  }

  public function getEditAdmin($id)
  {
    $data['active'] = 'adminList';
    $data['query'] = Admin::leftJoin('master__admin_information as i', 'i.admin_id', '=', 'id')
                          ->where('id', $id)
                          ->get(['id', 'name', 'email', 'phone', 'super', 'information']);

    return view('page.admin_edit_admin', $data);
  }

  public function postEditAdmin(Request $request, $id)
  {
    $v = Validator::make($request->all(), [
        'super' => 'required|digits_between:0,1|integer'
    ]);

    if ($v->fails())
    {
        return redirect('/admin/edit/' . $id)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $super = filter_var($input['super'], FILTER_SANITIZE_STRING);
    $info = filter_var($input['info'], FILTER_SANITIZE_STRING);

    $admin = Admin::find($id);
    $admin->super = $super;
    $admin->save();

    $data = AdminInfo::where('admin_id', $id)->first();
    $data->information = $info;
    $data->save();

    Session::flash('update', 1);
    return redirect('/admin/list');
  }

  public function deleteAdmin(Request $request)
  {
    $v = Validator::make($request->all(), [
        'id' => 'required'
    ]);

    if ($v->fails())
    {
        return 0;
    }    
    $input = $request->all();

    $id = filter_var($input['id'], FILTER_SANITIZE_STRING);
    
    AdminInfo::where('admin_id', $id)->forceDelete();

    Admin::find($id)->forceDelete();
    Session::flash('delete', 1);

    return 1;
  }


  //TRANSACTION
  public function getOrderList()
  {
    $data['active'] = 'txOrder';
    
    return view('page.admin_order', $data);
  }

  public function getOrderData(Request $request)
  {
    $data['query'] = TxOrder::leftJoin('master__member as c', 'customer_id', '=', 'c.id')
                            ->leftJoin('master__member as a', 'agent_id', '=', 'a.id')
                            ->leftJoin('master__city as city', 'city.city_id', '=', 'ship_city_id')
                            ->get(['order_id', 'a.name as agent', 'c.name as customer', 'order_date', 'ship_address', 'city_name', 'status_payment', 'status_confirmed', 'who']);
        

    return Datatables::of($data['query'])
    ->filter(function ($instance) use ($request) {
                if ($request->has('dateStart')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if($row['order_date'] >= $request->dateStart) return true;
                        return false;
                    });
                }

                if ($request->has('dateEnd')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if($row['order_date'] <= $request->dateEnd) return true;
                        return false;
                    });
                }

                if ($request->has('customer')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if(stripos($row['customer'], $request->customer) !== false) return true;
                        return false;
                    });
                }

                if ($request->has('agent')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if(stripos($row['agent'], $request->agent) !== false) return true;
                        return false;
                    });
                }

                if ($request->has('id')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if(stripos($row['order_id'], $request->id) !== false) return true;
                        return false;
                    });
                }
            })
    ->editColumn('status_payment', function($data){ 
        if($data->status_payment == 0) return "Unpaid";
        else if($data->status_payment == 1) return "Paid";
    })
    ->editColumn('status_confirmed', function($data){ 
        if($data->status_confirmed == 0) return "Unconfirmed";
        else if($data->status_confirmed == 1) return "Confirmed";
    })
    ->make(true);
  }

  public function getEditOrder($tmp)
  {
    $id = filter_var($tmp, FILTER_SANITIZE_STRING);
    $data['query'] = TxOrder::leftJoin('master__member as c', 'customer_id', '=', 'c.id')
                            ->leftJoin('master__member as a', 'agent_id', '=', 'a.id')
                            ->where('order_id', $id)
                            ->get(['order_id', 'c.name as cust', 'a.name as agent', 'order_date', 'status_payment' ,'status_confirmed']);
    
    $data['active'] = 'txOrder';

    return view('page.admin_edit_order', $data);
  }

  public function postEditOrder(Request $request, $id)
  {
    $id = filter_var($id, FILTER_SANITIZE_STRING);
    $v = Validator::make($request->all(), [
        'payment'    => 'required|numeric',
        'confirmed'    => 'required|numeric',
    ]);

    if ($v->fails())
    {
        return redirect('/admin/edit/order/' . $id)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();
    $confirmed = filter_var($input['confirmed'], FILTER_SANITIZE_STRING);
    $payment = filter_var($input['payment'], FILTER_SANITIZE_STRING);

    $order = TxOrder::find($id);
    $order->status_confirmed = $confirmed;
    $order->status_payment = $payment;
    $order->save();
    Session::flash('update', 1);

    return redirect('admin/order');
  }

  public function getProductOrder(Request $request)
  {
    $v = Validator::make($request->all(), [
        'id' => 'required'
    ]);

    if ($v->fails())
    {
        return 0;
    }    
    $input = $request->all();

    $id = filter_var($input['id'], FILTER_SANITIZE_STRING);
         
    $x = TxOrderDetail::leftJoin('transaction__order as tx', 'tx.order_id', '=', 'transaction__order_detail.order_id')
                ->leftJoin('product__varian as p', 'p.varian_id' , '=', 'transaction__order_detail.varian_id')
                ->where('transaction__order_detail.order_id', $id)
                ->get(['varian_name', 'quantity', 'varian_price']);

    
    $allData;
    $i = 0;
    
    foreach ($x as $tmp) {
      $data = new ProductData();
      $data->name = $tmp->varian_name;
      $data->quantity = $tmp->quantity;
      $data->price = $tmp->varian_price;

      $allData[$i] = $data;
      $i++;
    }

    if(isset($allData))
    {
      $json = json_encode($allData);

      return $json;
    }
    else return 0;
    
  }

  public function getShipList()
  {
    $data['active'] = 'txShipping';

    return view('page.admin_ship', $data);
  }

  public function getShipData(Request $request)
  {
    $data['query'] = TxShipDetail::leftJoin('transaction__shipping as tx', 'tx.shipping_id', '=', 'transaction__shipping_detail.shipping_id')
                            ->leftJoin('transaction__order as o', 'o.order_id', '=', 'tx.order_id')
                            ->leftJoin('master__member as c', 'o.customer_id', '=', 'c.id')
                            ->leftJoin('master__member as a', 'o.agent_id', '=', 'a.id')
                            ->leftJoin('master__city as city', 'city.city_id', '=', 'ship_city_id')
                            ->get(['tx.shipping_id as id', 'tx_shipping_id', 'a.name as agent', 'c.name as customer', 'order_date', 'ship_address', 'city_name', 'start_date', 'day', 'total_week', 'date_shipping' ,'finish']);
        
    return Datatables::of($data['query'])
    ->filter(function ($instance) use ($request) {
                if ($request->has('dateStart')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if($row['order_date'] >= $request->dateStart) return true;
                        return false;
                    });
                }

                if ($request->has('dateEnd')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if($row['order_date'] <= $request->dateEnd) return true;
                        return false;
                    });
                }

                if ($request->has('customer')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if(stripos($row['customer'], $request->customer) !== false) return true;
                        return false;
                    });
                }

                if ($request->has('agent')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if(stripos($row['agent'], $request->agent) !== false) return true;
                        return false;
                    });
                }
                if ($request->has('id')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if(stripos($row['tx_shipping_id'], $request->id) !== false) return true;
                        return false;
                    });
                }
            })
    ->editColumn('finish', function($data){ 
        if($data->finish == 0) return "Not Yet";
        else if($data->finish == 1) return "Finished";
    })
    ->make(true);
  }

  public function getEditShip($id)
  {
    $id = filter_var($id, FILTER_SANITIZE_STRING);
    $data['query'] = TxShipDetail::leftJoin('transaction__shipping as tx', 'tx.shipping_id', '=', 'transaction__shipping_detail.shipping_id')
                            ->leftJoin('transaction__order as o', 'o.order_id', '=', 'tx.order_id')
                            ->leftJoin('master__member as c', 'o.customer_id', '=', 'c.id')
                            ->leftJoin('master__member as a', 'o.agent_id', '=', 'a.id')
                            ->leftJoin('master__city as city', 'city.city_id', '=', 'ship_city_id')
                            ->where('tx.shipping_id', $id)
                            ->get(['tx.shipping_id as id', 'tx_shipping_id', 'a.name as agent', 'c.name as cust', 'order_date', 'ship_address', 'city_name', 'day', 'date_shipping' ,'finish']);
    
    $data['active'] = 'txShipping';

    return view('page.admin_edit_ship', $data);      
  }

  public function postEditShip(Request $request, $id)
  {
    $id = filter_var($id, FILTER_SANITIZE_STRING);
    $v = Validator::make($request->all(), [
        'finish'    => 'required|numeric',
    ]);

    if ($v->fails())
    {
        return redirect('/admin/edit/ship/' . $id)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();
    $finish = filter_var($input['finish'], FILTER_SANITIZE_STRING);

    $ship = TxShip::find($id);
    $ship->finish = $finish;
    $ship->save();
    Session::flash('update', 1);

    return redirect('admin/ship');
  }

  public function getProductShip(Request $request)
  {
    $v = Validator::make($request->all(), [
        'id' => 'required'
    ]);

    if ($v->fails())
    {
        return 0;
    }    
    $input = $request->all();

    $id = filter_var($input['id'], FILTER_SANITIZE_STRING);
         
    $x = TxShipDetail::leftJoin('transaction__shipping_product as tx', 'tx.tx_shipping_id', '=', 'transaction__shipping_detail.tx_shipping_id')
                ->leftJoin('product__varian as p', 'p.varian_id' , '=', 'tx.varian_id')
                ->where('tx.tx_shipping_id', $id)
                ->get(['varian_name', 'tx.qty as qty']);

    
    $allData;
    $i = 0;
    
    foreach ($x as $tmp) {
      $data = new SampleDetailData();
      $data->name = $tmp->varian_name;
      $data->quantity = $tmp->qty;

      $allData[$i] = $data;
      $i++;
    }

    if(isset($allData))
    {
      $json = json_encode($allData);

      return $json;
    }
    else return 0;
    
  }

  public function getCutOffDate()
  {
    $data['active'] = 'cutOffDate';
    $data['query'] = CutOffDate::find(1);
    
    return view('page.admin_cut_off_date', $data);
  }

  public function postCutOffDate(Request $request)
  {
    $v = Validator::make($request->all(), [
        'date'    => 'required|numeric',
    ]);

    if ($v->fails())
    {
        return redirect('/admin/cut/off/date')->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $date = filter_var($input['date'], FILTER_SANITIZE_STRING);

    $cutoff = CutOffDate::find(1);
    $cutoff->cut_off = $date;
    $cutoff->save();
    Session::flash('update', 1);

    return redirect('admin/cut/off/date');
  }

  public function getAboutUs()
  {
    $data['query'] = AboutUs::find(1);
    $data['active'] = 'aboutus';

    return view('page.admin_aboutus', $data);
  }

  public function postAboutUs(Request $request, $id)
  {
    $v = Validator::make($request->all(), [
        'name'    => 'required|max:100',
        'address' => 'required|max:500',
        'phone'   => 'required|numeric',
    ]);

    if ($v->fails())
    {
        return redirect('/admin/aboutus')->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $name = filter_var($input['name'], FILTER_SANITIZE_STRING);
    $address = filter_var($input['address'], FILTER_SANITIZE_STRING);
    $phone = filter_var($input['phone'], FILTER_SANITIZE_STRING);

    $aboutus = AboutUs::find($id);
    $aboutus->name = $name;
    $aboutus->address = $address;
    $aboutus->phone = $phone;
    $aboutus->save();
    Session::flash('update', 1);

    return redirect('admin/aboutus');
  }
  

  public function getCityList()
  {
    $data['active'] = "cityList";

    return view('admin_city', $data);
  }  

  public function getCityData()
  {
    $data['query'] = City::get(['city_id', 'city_name']);
        
    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getEditCity($id)
  {
    $data['query'] = City::find($id);
    $data['active'] = 'cityList';

    return view('page.admin_edit_city', $data);
  }

  public function postEditCity(Request $request, $id)
  {
    $v = Validator::make($request->all(), [
        'city'       => 'required|max:250',
    ]);

    if ($v->fails())
    {
        return redirect('/admin/edit/city/' . $id)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $inputCity = filter_var($input['city'], FILTER_SANITIZE_STRING);

    $city = City::find($id);
    $city->city_name = $inputCity;
    $city->save();
    Session::flash('update', 1);
    return redirect('/admin/city/list');
  }

  public function deleteCity(Request $request)
  {
    $v = Validator::make($request->all(), [
        'id' => 'required'
    ]);

    if ($v->fails())
    {
        return 0;
    }    
    $input = $request->all();

    $id = filter_var($input['id'], FILTER_SANITIZE_STRING);
         
    City::find($id)->delete();
    Session::flash('delete', 1);

    return 1;
  }

  public function insertCity()
  {
    $data['active'] = "insertCity";

    return view('page.admin_insert_city', $data);
  }

  public function postInsertCity(Request $request)
  {
    $v = Validator::make($request->all(), [
        'city'       => 'required|max:250',
    ]);

    if ($v->fails())
    {
        return redirect('/admin/insert/city')->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $inputCity = filter_var($input['city'], FILTER_SANITIZE_STRING);

    $city = new City();
    $city->city_name = $inputCity;
    $city->save();
    Session::flash('success', 1);
    return redirect('/admin/insert/city');
  }

  public function getReviewAgent()
  {
    $data['active'] = 'userReviewAgent';

    return view('page.admin_review_agent', $data);
  }

  public function getReviewAgentList()
  {
    $data['query'] = AgentRating::leftJoin('master__member as a', 'master__agent_rating.agent_id', '=', 'a.id')
                                ->leftJoin('master__member as c', 'master__agent_rating.customer_id', '=', 'c.id')
                                ->where('approval', 1)
                                ->get(['rating_id', 'a.name as agent', 'c.name as customer', 'rating', 'comment']);
        
    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getDeleteReviewAgent(Request $request)
  {
    $v = Validator::make($request->all(), [
        'id' => 'required'
    ]);

    if ($v->fails())
    {
        return 0;
    }    
    $input = $request->all();

    if(is_array($input['id']))
    {
      foreach ($input['id'] as $id)
      {
        $id = filter_var($id, FILTER_SANITIZE_STRING);
         
        AgentRating::find($id)->delete();
        Session::flash('delete', 1);
      }
    }
    else
    {
      $id = filter_var($input['id'], FILTER_SANITIZE_STRING);
      AgentRating::find($id)->delete();
      Session::flash('delete', 1);
    }

    return 1;
  }

  public function getReviewAgentRequest()
  {
    $data['active'] = 'userReviewAgentRequest';

    return view('page.admin_review_agent_request', $data);
  }  

  public function getProcessReviewAgentList()
  {
    $data['query'] = AgentRating::leftJoin('master__member as a', 'master__agent_rating.agent_id', '=', 'a.id')
                                ->leftJoin('master__member as c', 'master__agent_rating.customer_id', '=', 'c.id')
                                ->where('approval', 0)
                                ->get(['rating_id', 'a.name as agent', 'c.name as customer', 'rating', 'comment']);
    
    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getProcessReviewAgent(Request $request)
  {
    $v = Validator::make($request->all(), [
        'id' => 'required',
        'action' => 'required|alpha'
    ]);

    if ($v->fails())
    {
        return 0;
    }    
    $input = $request->all();
    $action = filter_var($input['action'], FILTER_SANITIZE_STRING);

    if(is_array($input['id']))
    {
      foreach ($input['id'] as $id)
      {
        $id = filter_var($id, FILTER_SANITIZE_STRING);
         
        if($action == "reject")
        {
          AgentRating::find($id)->delete();
          Session::flash('reject', 1);
        }
        else if($action == "approve")
        {
          $rating = AgentRating::find($id);
          $rating->approval = 1;
          $rating->save();
          Session::flash('approve', 1);
        }
      }
    }
    else
    {
      $id = filter_var($input['id'], FILTER_SANITIZE_STRING);
      if($action == "reject")
      {
        $rating = AgentRating::find($id)->delete();
        Session::flash('reject', 1);
      }
      else if($action == "approve")
      {
        $rating = AgentRating::find($id);
        $rating->approval = 1;
        $rating->save();

        Session::flash('approve', 1);
      }
    }

    return 1;
  }

  public function getAgentList()
  {
      $data['active'] = "userAgentList";
      Session::flash('new', 1);

      return view('page.admin_agent', $data);
  }

  public function getAgentData()
  {
      $data['query'] = User::leftJoin('master__city', 'master__member.city_id', '=', 'master__city.city_id')
                            ->where('status_user', 0)
                            ->get(['id', 'name', 'address', 'master__member.city_id', 'date_of_birth', 'email', 'phone', 'verification', 'balance', 'bank_account','city_name']);
        
      return Datatables::of($data['query'])
      ->make(true);
  }

  public function getEditAgent($id)
  {
    $data['query'] = User::find($id);
    $data['active'] = "userAgentList";

    return view('page.admin_edit_agent', $data);
  }

  public function postEditAgent(Request $request, $id)
  {
    $v = Validator::make($request->all(), [
        'status'       => 'required|numeric',
        'verification' => 'required|numeric',
    ]);    

    if ($v->fails())
    {
        return redirect('/admineditagent/' . $id)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $status = filter_var($input['status'], FILTER_SANITIZE_STRING);
    $verification = filter_var($input['verification'], FILTER_SANITIZE_STRING);

    $user = User::find($id);
    $user->status_user = $status;
    $user->verification = $verification;
    $user->save();

    Session::flash('update', 1);

    return redirect('admin/agent/list');
  }

  public function getAgentTxData(Request $request)
  {
    $id = filter_var($request->id, FILTER_SANITIZE_STRING);
    $data['query'] = TxOrder::leftJoin('master__member as c', 'customer_id', '=', 'c.id')
                            ->leftJoin('master__member as a', 'agent_id', '=', 'a.id')
                            ->leftJoin('master__city as city', 'city.city_id', '=', 'ship_city_id')
                            ->where('transaction__order.agent_id', $id)
                            ->get(['order_id', 'a.name as agent', 'c.name as customer', 'order_date', 'ship_address', 'city_name', 'status_payment', 'status_confirmed', 'who']);
        
    return Datatables::of($data['query'])
    ->make(true);
  }
  
  public function getEditAgentTx($id)
  {
    $id = filter_var($id, FILTER_SANITIZE_STRING);
    $data['active'] = "userAgentList";
    $data['query'] = TxOrder::leftJoin('master__member as c', 'customer_id', '=', 'c.id')
                            ->leftJoin('master__member as a', 'agent_id', '=', 'a.id')
                            ->where('order_id', $id)
                            ->get(['order_id', 'a.id as AId', 'c.name as cust', 'a.name as agent', 'order_date', 'status_payment' ,'status_confirmed']);

    return view('page.admin_edit_agent_tx', $data);
  }


  public function postEditAgentTx(Request $request, $orderId, $AId)
  {
    $v = Validator::make($request->all(), [
        'payment' => 'required|numeric',
        'confirmed' => 'required|numeric',
    ]);    

    if ($v->fails())
    {
        return redirect('/admin/edit/agent/tx/' . $orderId)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $payment = filter_var($input['payment'], FILTER_SANITIZE_STRING);
    $confirmed = filter_var($input['confirmed'], FILTER_SANITIZE_STRING);
    $AId = filter_var($AId, FILTER_SANITIZE_STRING);

    $tx = TxOrder::find($orderId);
    $tx->status_payment = $payment;
    $tx->status_confirmed = $confirmed;
    $tx->save();
    Session::flash('update', 1);

    return redirect('/admin/edit/agent/' . $AId);
  }

  public function getCustomerList()
  {
      $data['active'] = "userMemberList";

      return view('page.admin_customer', $data);
  }

  public function getCustomerData()
  {
      $data['query'] = User::leftJoin('master__city', 'master__member.city_id', '=', 'master__city.city_id')
                            ->where('status_user', 1)
                            ->get(['id', 'name', 'address', 'master__member.city_id', 'date_of_birth', 'email', 'phone', 'verification', 'city_name']);
        
      return Datatables::of($data['query'])
      ->make(true);
  }

  public function getEditCustomer($id)
  {
    $data['active'] = "userMemberList";
    $data['query'] = User::find($id);

    return view('page.admin_edit_customer', $data);
  }

  public function postEditCustomer(Request $request, $id)
  {
    $v = Validator::make($request->all(), [
        'status'       => 'required|numeric',
        'verification' => 'required|numeric',
    ]);    

    if ($v->fails())
    {
        return redirect('/admin/edit/customer/' . $id)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $status = filter_var($input['status'], FILTER_SANITIZE_STRING);
    $verification = filter_var($input['verification'], FILTER_SANITIZE_STRING);

    $user = User::find($id);
    $user->status_user = $status;
    $user->verification = $verification;
    $user->save();

    Session::flash('update', 1);

    return redirect('/admin/customer/list/');
  }

  public function getCustomerTxData(Request $request)
  {
    $id = filter_var($request->id, FILTER_SANITIZE_STRING);
    $data['query'] = TxOrder::leftJoin('master__member as c', 'customer_id', '=', 'c.id')
                            ->leftJoin('master__member as a', 'agent_id', '=', 'a.id')
                            ->leftJoin('master__city as city', 'city.city_id', '=', 'ship_city_id')
                            ->where('transaction__order.customer_id', $id)
                            ->get(['order_id', 'a.name as agent', 'c.name as customer', 'order_date', 'ship_address', 'city_name', 'status_payment', 'status_confirmed', 'who']);
        
    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getEditCustomerTx($id)
  {
    $id = filter_var($id, FILTER_SANITIZE_STRING);
    $data['active'] = "userMemberList";
    $data['query'] = TxOrder::leftJoin('master__member as c', 'customer_id', '=', 'c.id')
                            ->leftJoin('master__member as a', 'agent_id', '=', 'a.id')
                            ->where('order_id', $id)
                            ->get(['order_id', 'c.id as CId', 'c.name as cust', 'a.name as agent', 'order_date', 'status_payment' ,'status_confirmed']);

    return view('page.admin_edit_customer_tx', $data);
  }

  public function postEditCustomerTx(Request $request, $orderId, $CId)
  {
    $v = Validator::make($request->all(), [
        'payment' => 'required|numeric',
        'confirmed' => 'required|numeric',
    ]);    

    if ($v->fails())
    {
        return redirect('/admin/edit/customer/tx/' . $orderId)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $payment = filter_var($input['payment'], FILTER_SANITIZE_STRING);
    $confirmed = filter_var($input['confirmed'], FILTER_SANITIZE_STRING);
    $CId = filter_var($CId, FILTER_SANITIZE_STRING);

    $tx = TxOrder::find($orderId);
    $tx->status_payment = $payment;
    $tx->status_confirmed = $confirmed;
    $tx->save();
    Session::flash('update', 1);

    return redirect('/admin/edit/customer/' . $CId);
  }

  //fungsi buat FAQ
  public function getFaqList()
  {
      $data['active'] = "faqList";

      return view('page.admin_faq', $data);
  }

  public function getFaqData()
  {
      $data['query'] = Faq::get(['question_id', 'question', 'answer']);
        
      return Datatables::of($data['query'])
      ->make(true);
  }  

  public function getEditFaq($id)
  {
    $data['query'] = Faq::find($id);
    $data['active'] = "faqList";

    return view('page.admin_edit_faq', $data);
  }

  public function postEditFaq(Request $request, $id)
  {
    $v = Validator::make($request->all(), [
        'question' => 'required|max:10000',
        'answer' => 'required|max:10000',
    ]);    

    if ($v->fails())
    {
        return redirect('/admin/edit/faq/' . $id)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $question = filter_var($input['question'], FILTER_SANITIZE_STRING);
    $answer = filter_var($input['answer'], FILTER_SANITIZE_STRING);

    $faq = Faq::find($id);
    $faq->question = $question;
    $faq->answer = $answer;
    $faq->save();

    return redirect('/admin/faq/list');
  }

  public function getInsertFaq()
  {
    $data['active'] = 'insertFaq';

    return view ('page.admin_insert_faq', $data);
  }

  public function postInsertFaq(Request $request)
  {
    $v = Validator::make($request->all(), [
        'question' => 'required|max:10000',
        'answer' => 'required|max:10000',
    ]);    

    if ($v->fails())
    {
        return redirect('/admin/insert/faq')->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $question = filter_var($input['question'], FILTER_SANITIZE_STRING);
    $answer = filter_var($input['answer'], FILTER_SANITIZE_STRING);

    $faq = new Faq;
    $faq->question = $question;
    $faq->answer = $answer;
    $faq->save();

    Session::flash('success', 1);

    return redirect('/admin/insert/faq');
  }

  public function getDeleteFaq(Request $request)
  {
    $v = Validator::make($request->all(), [
        'id' => 'required'
    ]);

    if ($v->fails())
    {
        return 0;
    }    
    $input = $request->all();

    $id = filter_var($input['id'], FILTER_SANITIZE_STRING);
         
    Faq::find($id)->delete();
    Session::flash('delete', 1);

    return 1;
  }

  //fungsi buat product
  public function getSampleRequest()
  {
    $data['active'] = 'productSampleRequest';
    /*$data['query'] = SampleDetail::leftJoin('transaction__sample_request as r', 'r.request_id', '=', 'transaction__sample_detail.request_id')
                                  ->leftJoin('product__varian as p', 'p.varian_id' , '=', 'transaction__sample_detail.varian_id')
                                  ->where('approval', 0)
                                  ->get(['varian_name', 'quantity']);*/

    return view('page.admin_sample_request', $data);
  }

  public function getSampleData()
  {
    $data['query'] = SampleRequest::leftJoin('master__member as m', 'm.id', '=', 'agent_id')
                                    ->where('approval', 0)
                                    ->get(['transaction__sample_request.request_id', 'name', 'event_name', 'event_date', 'event_venue', 'event_description', 'request_date']);

    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getSampleDetail(Request $request)
  {
    $v = Validator::make($request->all(), [
        'id' => 'required'
    ]);

    if ($v->fails())
    {
        return 0;
    }    
    $input = $request->all();

    $id = filter_var($input['id'], FILTER_SANITIZE_STRING);
         
    $x = SampleDetail::leftJoin('transaction__sample_request as r', 'r.request_id', '=', 'transaction__sample_detail.request_id')
                                  ->leftJoin('product__varian as p', 'p.varian_id' , '=', 'transaction__sample_detail.varian_id')
                                  ->where('approval', 0)
                                  ->where('transaction__sample_detail.request_id', $id)
                                  ->get(['varian_name', 'quantity']);


    
    $allData;
    $i = 0;
    
    foreach ($x as $tmp) {
      $data = new SampleDetailData();
      $data->name = $tmp->varian_name;
      $data->quantity = $tmp->quantity;

      $allData[$i] = $data;
      $i++;
    }

    if(isset($allData))
    {
      $json = json_encode($allData);

      return $json;
    }
    else return 0;
  }

  public function getProcessSampleRequest(Request $request)
  {
    $v = Validator::make($request->all(), [
        'id' => 'required',
        'action' => 'required|alpha'
    ]);

    if ($v->fails())
    {
        return 0;
    }    
    $input = $request->all();
    $action = filter_var($input['action'], FILTER_SANITIZE_STRING);

    if(is_array($input['id']))
    {
      foreach ($input['id'] as $id)
      {
        $id = filter_var($id, FILTER_SANITIZE_STRING);
         
        if($action == "reject")
        {
          $sample = SampleRequest::find($id)->delete();
          Session::flash('reject', 1);
        }
        else if($action == "approve")
        {
          $sample = SampleRequest::find($id);
          $sample->approval = 1;
          $sample->save();
          Session::flash('approve', 1);
        }
      }
    }
    else
    {
      $id = filter_var($input['id'], FILTER_SANITIZE_STRING);
      if($action == "reject")
      {
        $sample = SampleRequest::find($id)->delete();
        Session::flash('reject', 1);
      }
      else if($action == "approve")
      {
        $sample = SampleRequest::find($id);
        $sample->approval = 1;
        $sample->save();

        Session::flash('approve', 1);
      }
    }

    return 1;
  }

  public function getTestimonialList()
  {
    $data['active'] = 'productTestimonial';
    
    return view('page.admin_product_testimonial', $data);
  }

  public function getTestimonialData()
  {
    $data['query'] = ProductTestimonial::leftJoin('master__member', 'product__testimonial.id', '=', 'master__member.id')
                                    ->leftJoin('product__varian', 'product__testimonial.varian_id', '=', 'product__varian.varian_id')
                                    ->where('approval', 1)
                                    ->get(['varian_name', 'name', 'testimonial_id', 'testimonial']);

    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getDeleteTestimoni(Request $request)
  {
    $v = Validator::make($request->all(), [
        'id' => 'required'
    ]);

    if ($v->fails())
    {
        return 0;
    }    
    $input = $request->all();

    if(is_array($input['id']))
    {
      foreach ($input['id'] as $id)
      {
        $id = filter_var($id, FILTER_SANITIZE_STRING);
         
        ProductTestimonial::find($id)->delete();
        Session::flash('delete', 1);
      }
    }
    else
    {
      $id = filter_var($input['id'], FILTER_SANITIZE_STRING);
      ProductTestimonial::find($id)->delete();
      Session::flash('delete', 1);
    }

    return 1;
  }

  public function getTestimonialRequest()
  {
    $data['active'] = "productTestimonialRequest";

    return view('page.admin_product_testimonial_request', $data);
  }

  public function getProcessTestimonialData()
  {
    $data['query'] = ProductTestimonial::leftJoin('master__member', 'product__testimonial.id', '=', 'master__member.id')
                                    ->leftJoin('product__varian', 'product__testimonial.varian_id', '=', 'product__varian.varian_id')
                                    ->where('approval', 0)
                                    ->get(['varian_name', 'name', 'testimonial_id', 'testimonial']);

    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getProcessTestimoni(Request $request)
  {
    $v = Validator::make($request->all(), [
        'id' => 'required',
        'action' => 'required|alpha'
    ]);

    if ($v->fails())
    {
        return 0;
    }    
    $input = $request->all();
    $action = filter_var($input['action'], FILTER_SANITIZE_STRING);

    if(is_array($input['id']))
    {
      foreach ($input['id'] as $id)
      {
        $id = filter_var($id, FILTER_SANITIZE_STRING);
        
        $testi = ProductTestimonial::find($id);
        if($action == "reject")
        {
          $testi->delete(); 
        }
        else if($action == "approve")
        {
          $testi->approval = 1;
          $testi->save();
        }
      }
    }
    else
    {
      $id = filter_var($input['id'], FILTER_SANITIZE_STRING);

      $testi = ProductTestimonial::find($id);
      if($action == "reject")
      {
        $testi->delete(); 
      }
      else if($action == "approve")
      {
        $testi->approval = 1;
        $testi->save();
      }
    }

    if($action == "reject")
    {
      Session::flash('reject', 1);
    }
    else if($action == "approve")
    {
      Session::flash('approve', 1);
    }

    return 1;
  }

  

  public function getCategoryList()
  {
    $data['active'] = 'productCategory';

    return view('page.admin_product_category', $data);
  }

  public function getCategoryData()
  {
    $data['query'] = ProductCategory::get(['category_id', 'category_name', 'description']);

    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getEditCategory($id)
  {
    $data['query'] = ProductCategory::find($id);
    $data['active'] = 'productCategory';

    return view('page.admin_edit_category', $data);
  }

  public function postEditCategory(Request $request, $id)
  {
    $v = Validator::make($request->all(), [
        'description' => 'max:10000'
    ]);    

    if ($v->fails())
    {
        return redirect('/admin/edit/category/' . $id)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $desc = filter_var($input['description'], FILTER_SANITIZE_STRING);

    $category = ProductCategory::find($id);
    $category->description = $desc;
    $category->save();
    Session::flash('update', 1);
    return redirect('/admin/category/list');
  }

  public function getDeleteCategory(Request $request)
  {
    $v = Validator::make($request->all(), [
        'id' => 'required'
    ]);

    if ($v->fails())
    {
        return 0;
    }    
    $input = $request->all();

    $id = filter_var($input['id'], FILTER_SANITIZE_STRING);
    
    ProductCategory::find($id)->delete();
    Session::flash('delete', 1);

    return 1;
  }

  public function getProductList()
  {
    $data['active'] = "productList";

    return view('page.admin_product', $data);
  }

  public function getProductData()
  {
    $data['query'] = Product::leftJoin('product__category', 'product__category.category_id', '=', 'product__varian.category_id')
                            ->get(['category_name', 'varian_id', 'varian_name', 'price', 'qty', 'picture', 'weight', 'product__varian.description']);
    
      return Datatables::of($data['query'])
      //->addColumn('actions', '<button id="a">a</button> <br> <button>b</button>')
      ->make(true);
  }

  public function getInsertProduct()
  {
    $data['query'] = ProductCategory::get(['category_id', 'category_name']);
    $data['active'] = "insertProduct";

    return view('page.admin_insert_product', $data);
  }

  public function postInsertProduct(Request $request)
  {
    $input = $request->all();

    //kalo dia insert new category
    if($input['category'] == 0)
    {
      $v = Validator::make($request->all(), [
          'name' => 'required|max:100',
          'price' => 'required|numeric',
          'quantity' => 'required|numeric',
          'weight' => 'required|numeric',
          'description' => 'required|alpha',
          'category' => 'required|numeric',
          'picture' => 'required|mimes:jpg,jpeg,png',
          'newcategory' => 'required|unique:product__category,category_name|max:100',
      ]);
    }
    else
    {
      $v = Validator::make($request->all(), [
          'name' => 'required|max:100',
          'price' => 'required|numeric',
          'quantity' => 'required|numeric',
          'weight' => 'required|numeric',
          'description' => 'required|alpha',
          'category' => 'required|numeric',
          'picture' => 'required|mimes:jpg,jpeg,png',
      ]);
    }    

    if ($v->fails())
    {
        return redirect('/admin/insert/product')->withErrors($v->errors())->withInput();
    }    

    $name = filter_var($input['name'], FILTER_SANITIZE_STRING);
    $price = filter_var($input['price'], FILTER_SANITIZE_STRING);
    $quantity = filter_var($input['quantity'], FILTER_SANITIZE_STRING);
    $weight = filter_var($input['weight'], FILTER_SANITIZE_STRING);
    $description = filter_var($input['description'], FILTER_SANITIZE_STRING);
    $category = filter_var($input['category'], FILTER_SANITIZE_STRING);
    $picture = $input['picture'];
    if($picture->getClientSize() > 512000)
    {
      return redirect('/admin/insert/product')->with('errorSize', 'The picture size cannot be larger than 500 kilobytes')->withInput();
    }

    $fileName = filter_var($picture->getClientOriginalName(), FILTER_SANITIZE_STRING);
    $fileName = preg_replace('~[\\\\/:*?"<>|-]~', '', $fileName);
    $fileName = str_replace(' ', '_', $fileName);
    $fileName = time() . $fileName;

    //kalo new category, berarti insert dulu category barunya
    if($category == 0)
    {
      $newcategory = filter_var($input['newcategory'], FILTER_SANITIZE_STRING);
      $newdesc = filter_var($input['newcategorydesc'], FILTER_SANITIZE_STRING);
      
      $data = new ProductCategory;
      $data->category_name = $newcategory;
      $data->description = $newdesc;
      $data->save();
    }

    $product = new Product;
    $product->varian_name = $name;
    $product->price = $price;
    $product->qty = $quantity;
    $product->description = $description;
    $product->weight = $weight;
    if($category == 0) //kalo insert category baru
      $product->category_id = $data->category_id;
    else
      $product->category_id = $category;
    $product->picture = $fileName;
    $product->save();

    //cek database categorynya itu apa, buat pindahin gambar
    if($category == 0) //kalo new category, berarti ambil category yang baru
      $query = ProductCategory::find($data->category_id);
    else //kalo dia pake kategori yang udah ada
      $query = ProductCategory::find($category);
    //pindahin gambarnya
    $picture->move(base_path() . '/public/assets/images/product/' . $query->category_name . '/', $fileName);

    Session::flash('insert', 1);
    return redirect('admin/insert/product/');
  }

  public function getEditProduct($id)
  {
    $data['query'] = Product::find($id);
    $data['category'] = ProductCategory::find($data['query']->category_id);
    $data['allCategory'] = ProductCategory::all();
    $data['active'] = "productList";

    return view('page.admin_edit_product', $data);
  }

  public function postEditProduct(Request $request, $id)
  {
    $input = $request->all();

    //kalo dia insert new category
    if($input['category'] == 0)
    {
      $v = Validator::make($request->all(), [
          'name' => 'required|max:100',
          'price' => 'required|numeric',
          'quantity' => 'required|numeric',
          'weight' => 'required|numeric',
          'description' => 'required',
          'category' => 'required|numeric',
          'picture' => 'mimes:jpg,jpeg,png',
          'newcategory' => 'required|unique:product__category,category_name|max:100',
      ]);
    }
    else
    {
      $v = Validator::make($request->all(), [
          'name' => 'required|max:100',
          'price' => 'required|numeric',
          'quantity' => 'required|numeric',
          'weight' => 'required|numeric',
          'description' => 'required',
          'category' => 'required|numeric',
          'picture' => 'mimes:jpg,jpeg,png',
      ]);
    }    

    if ($v->fails())
    {
        return redirect('/admin/edit/product/' . $id)->withErrors($v->errors())->withInput();
    }    

    $name = filter_var($input['name'], FILTER_SANITIZE_STRING);
    $price = filter_var($input['price'], FILTER_SANITIZE_STRING);
    $quantity = filter_var($input['quantity'], FILTER_SANITIZE_STRING);
    $weight = filter_var($input['weight'], FILTER_SANITIZE_STRING);
    $description = filter_var($input['description'], FILTER_SANITIZE_STRING);
    $category = filter_var($input['category'], FILTER_SANITIZE_STRING);
    
    //kalo upload file baru
    if($_FILES["picture"]["error"] != 4) 
    {
      $picture = $input['picture'];

      if($picture->getClientSize() > 512000)
      {
        return redirect('/admin/edit/product/' . $id)->with('errorSize', 'The picture size cannot be larger than 500 kilobytes')->withInput();
      }

      $fileName = filter_var($picture->getClientOriginalName(), FILTER_SANITIZE_STRING);
      $fileName = preg_replace('~[\\\\/:*?"<>|-]~', '', $fileName);
      $fileName = str_replace(' ', '_', $fileName);
      $fileName = time() . $fileName;
    }
    else //kalo ga upload file baru
    {
      $picture = null;
    }

    //kalo new category, berarti insert dulu category barunya
    if($category == 0)
    {
      $newcategory = filter_var($input['newcategory'], FILTER_SANITIZE_STRING);
      $newdesc = filter_var($input['newcategorydesc'], FILTER_SANITIZE_STRING);
      
      $data = new ProductCategory;
      $data->category_name = $newcategory;
      $data->description = $newdesc;
      $data->save();
    }

    $product = Product::find($id);
    //ambil data picture lama, untuk di delete gambarnya
    $oldPicture = $product->picture;
    //ambil data kategori lama, untuk di delete gambarnya
    $oldCategory = $product->category_id;


    $product->varian_name = $name;
    $product->price = $price;
    $product->qty = $quantity;
    $product->description = $description;
    $product->weight = $weight;
    if($category == 0) //kalo insert category baru
      $product->category_id = $data->category_id;
    else
      $product->category_id = $category;
    if($picture != null)
      $product->picture = $fileName;
    $product->save();

    //cek database categorynya itu apa, buat pindahin gambar
    if($picture != null)
    {
      if($category == 0) //kalo new category, berarti ambil category yang baru
        $query = ProductCategory::find($data->category_id);
      else //kalo dia pake kategori yang udah ada
        $query = ProductCategory::find($category);
      //pindahin gambarnya
      $picture->move(base_path() . '/public/assets/images/product/' . $query->category_name . '/', $fileName);
    
      //hapus file yang lama
      $category = ProductCategory::find($oldCategory);

      $path = base_path() . "/public/assets/images/product/" . $category->category_name . "/" . $oldPicture;
      $fileExist = file_exists($path);
      if($fileExist)
      {
        unlink($path);
      }
    }

    $query = Product::find($id);

    //kalo dia cuma ganti category doang, file gambarnya harus dipindah
    if($picture == null && $oldCategory != $query->category_id)
    {
      $category = ProductCategory::find($oldCategory);
      $newCategory = ProductCategory::find($product->category_id);

      $path = base_path() . "/public/assets/images/product/" . $category->category_name . "/" . $oldPicture;
      $newPath = base_path() . "/public/assets/images/product/" . $newCategory->category_name . "/" . $oldPicture;
      $fileExist = file_exists($path);
      if($fileExist)
      {
        copy($path, $newPath);
        unlink($path);
      }
    }
    Session::flash('update', 1); 
    return redirect('/admin/');
  }

  public function getDeleteProduct(Request $request)
  {
    $v = Validator::make($request->all(), [
        'id' => 'required'
    ]);

    if ($v->fails())
    {
        return 0;
    }    
    $input = $request->all();

    $id = filter_var($input['id'], FILTER_SANITIZE_STRING);

    Product::where('varian_id', $id)->delete();
    Session::flash('delete', 1);

    return 1;
  }

}


