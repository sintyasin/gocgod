<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Auth;
use Cart;
use App\Http\Requests;
use App\Product;
use App\Banner;
use App\ProductCategory;
use App\NameProduct;
use App\ProductTestimonial;
use App\Member;
use App\Balance;
use App\TxOrder;
use App\TxOrderDetail;
use Yajra\Datatables\Datatables;
use App\City;
use App\CutOffDate;
use Session;
use App\AboutUs;
use Mail;

class ProductDataOrder
{
public $name;
public $quantity;
public $price;
}

//=========================== CHECKOUT SINGLE
class TransactionController extends Controller
{
  public function customerCart()
  {
    return view('page.customercart');
  }
  
  public function order_details_single()
  {
    $data['contact'] = AboutUs::first();
    $data['agent'] = Member::leftJoin('master__city as c', 'master__member.city_id', '=', 'c.city_id')
    ->where('status_user', 0)
    ->get();

    $start = "";
    date_default_timezone_set('Asia/Jakarta');
    if(date("l") == "Friday")
    {
      $now = strtotime(date("H:i"));
      $plusdate = date("H:i", strtotime('+20 minutes', $now));
      if($plusdate > "17:00")
      {
        $cutoff = CutOffDate::find(1);
        $today = new \DateTime(NULL);
        date_add($today,date_interval_create_from_date_string("+".$cutoff->cut_off." days"));
        $start = date_format($today,"Y-m-d");
      }
      else
      {
        $start = date("Y-m-d", strtotime( "next monday"));
      }
    }
    else 
    {
      if(date("l") == "Saturday")
      {
        $cutoff = CutOffDate::find(1);
        $today = new \DateTime(NULL);
        date_add($today,date_interval_create_from_date_string("+".($cutoff->cut_off - 1)." days"));
        $start = date_format($today,"Y-m-d");
      }
      else if(date("l") == "Sunday")
      {
        $cutoff = CutOffDate::find(1);
        $today = new \DateTime(NULL);
        date_add($today,date_interval_create_from_date_string("+".($cutoff->cut_off - 2)." days"));
        $start = date_format($today,"Y-m-d"); 
      }
      else
      {
        $start = date("Y-m-d", strtotime( "next monday"));
      }
    }
    
    $data['start'] = $start;

    $data['city'] = City::all();

    return view('page.checkout_single', $data);
  }

  public function addtocart(Request $data)
  {
    $v = Validator::make($data->all(),[
      'qty' =>'required|numeric',
      ]);
    if($v->fails())
    {
      return "Not completed data";
    }

    Cart::add([
      'id'=> $data->id, 
      'qty' => $data->qty,
      'name' => $data->name,
      'price' => $data->price,
      ]);
  }

  public function updatecart_single(Request $data)
  {
    $v = Validator::make($data->all(),[
      'qty' =>'required|numeric',
      'id' =>'required',
      ]);

    if($v->fails())
    {
      return "Not completed data";
    }

    $qty = $data->qty;
    $rowid = $data->rowId; 
    $id = $data->id; 

    if ($qty <= 0) {
      return 'Quantity not valid';
    }else {
      $product = \DB::table('product__varian')->where('varian_id', $id)->first();
      Cart::update($data->rowId, $qty);
      $subtotal = $product->price * $qty;
      $total = Cart::total();

      $response = array(
        'subtotal' => $subtotal,
        'total' => $total);

      return response()->json(compact('response'));
    }
  }

  public function deletecart_single(Request $data)
  {

    $v = Validator::make($data->all(),[
      'qty' =>'required|numeric',
      ]);
    if($v->fails())
    {
      return "Not completed data";
    }
    Cart::remove($data->rowId);
    $total = Cart::total();

    $response = array(
      'total' => $total);

    return response()->json(compact('response'));
  }

  public function order_single(Request $request)
  {
    $v = Validator::make($request->all(),[
      'address' => 'required|max:500',
      'city' => 'required|numeric',
      'agent' => 'required|numeric',
      'request_date' =>  'required|max:10',
      'zipcode' => 'required|max:50',
      ]);

    if ($v->fails())
    {
      return redirect('checkout_singlebuyer/')->withErrors($v->errors())->withInput();
    }

    $input = $request->all();

    $customer_id = Auth::user()->id;
    $agent_id = filter_var($input['agent'], FILTER_SANITIZE_STRING);
    $ship_address = filter_var($input['address'], FILTER_SANITIZE_STRING);
    $ship_city_id = filter_var($input['city'], FILTER_SANITIZE_STRING);
    $zipcode = filter_var($input['zipcode'], FILTER_SANITIZE_STRING);
    $shipping_date = filter_var($input['request_date'], FILTER_SANITIZE_STRING);
    if(Cart::count() >= 5)
    {
      $shipping_fee = 0;
    }
    else
    {
      $shipping_fee = 10000;
    }
    $who = 'single';
    $total = Cart::total();

    $a = TxOrder::orderBy('group_id', 'desc')->first();
    $group;

    if(empty($a))
      $group = 1;
    else
    {
      $group = $a->group_id + 1;
    }    

    
    $date_shipping = new \DateTime($shipping_date);
    $date = date_format($date_shipping,"Y-m-d"); 

    date_default_timezone_set('Asia/Jakarta');
    $date_order = new  \DateTime();
    $order_date = date_format($date_order, "Y-m-d H:i:s");

    $order = new TxOrder;
    $order->customer_id = $customer_id;
    $order->agent_id = $agent_id;
    $order->ship_address = $ship_address;
    $order->ship_city_id = $ship_city_id;
    $order->zipcode = $zipcode;
    $order->shipping_date = $date;
    $order->group_id = $group;
    $order->shipping_fee = $shipping_fee;
    $order->total = $total + $shipping_fee;
    $order->who = $who;
    $order->order_date = $order_date;
    if($input['payment'] == 0) //bank transfer.   kalo firstpay ga ush diisi dulu (biarin null)
    {
      $order->payment_method = 0;
    }
    $order->save();
   

    foreach(Cart::content() as $single)
    {
      $b = TxOrder::orderBy('order_id', 'desc')->first();
      $details = new TxOrderDetail;
      $details->order_id = $b->order_id;
      $details->varian_id = $single->id;
      $details->varian_price = $single->price;
      $details->quantity = $single->qty;
      $details->save();
    }

    Cart::destroy();

    if($order->payment_method == null || $order->payment_method == 'null')//firstpay
      return redirect('/payment/confirm/'.$order->order_id);
    else if($order->payment_method == 0) //kalo bank transfer langsung ke payment
      return redirect('/payment/'.$order->order_id);
  }

  public function paymentConfirm($id)
  {
    $data['order'] = TxOrder::find($id);
    $data['contact'] = AboutUs::first();
    
    $query = Member::where('id', $data['order']->customer_id)
                                  ->leftJoin('master__city as c', 'c.city_id', '=', 'master__member.city_id')
                                  ->get(['city_name']);


    $data['customerCity'] = $query[0]->city_name;

    $signature = 'gocgod' . 'gocgod123' . $data['order']->group_id . $data['order']->total;
    
    $data['signature'] = md5($signature);
        
    return view('page.paymentconfirm', $data);
  }

  public function banktransfer($id)
  {
    $data['order'] = TxOrder::find($id);
    $data['orderdetail'] = \DB::table('transaction__order_detail')
                  ->select(\DB::raw('SUM(quantity) as quantity'))
                  ->groupBy('order_id')
                  ->get();
    $data['contact'] = AboutUs::first();
    $data['order_a'] = TxOrder::where('order_id', $id)->get();
    $data['orderprice'] = \DB::table('transaction__order')
                  ->select('total as total_price')
                  ->where('order_id', '=', $id)
                  ->get();

    $data['orderdetails'] = TxOrderDetail::where('order_id', $data['order']->order_id)
                            ->leftJoin('product__varian as pv', 'transaction__order_detail.varian_id', '=', 'pv.varian_id')
                            ->get(['varian_name', 'price', 'quantity']);
        
    $data['agent'] = Member::where('id', $data['order']->agent_id)
                            ->get(['name']);

    $data['status_payment'] = 'Pending';
    $data['payment_method'] = 'Bank Transfer';

    Mail::send('page.email', $data, function ($m) {
        $m->from('gocgod@gocgod.com', 'noreply-gocgod');

        $m->to(Auth::user()->email, Auth::user()->name)->subject('Pesanan Anda Telah Didaftarkan');
    });

    return view('page.summary', $data);
  }

  //redirect dari firstpay
  public function payment(Request $request)
  {
    $xml = simplexml_load_string($request->getContent());    
    $id = filter_var($xml->idorder, FILTER_SANITIZE_STRING);

    $data['order'] = TxOrder::find($id);

    $data['status_payment'] = '';
    $data['payment_method'] = '';

    $amount = $data['order']->total;
    $signature = md5('gocgod' . 'gocgod123'. $id . $amount);

    if($signature == $xml->signature)
    {
      $data['orderdetail'] = \DB::table('transaction__order_detail')
                    ->select(\DB::raw('SUM(quantity) as quantity'))
                    ->groupBy('order_id')
                    ->get();
      $data['contact'] = AboutUs::first();
      $data['order_a'] = TxOrder::where('order_id', $id)->get();
      $data['orderprice'] = \DB::table('transaction__order')
                    ->select('total as total_price')
                    ->where('order_id', '=', $id)
                    ->get();

      $data['orderdetails'] = TxOrderDetail::where('order_id', $data['order']->order_id)
                              ->leftJoin('product__varian as pv', 'transaction__order_detail.varian_id', '=', 'pv.varian_id')
                              ->get(['varian_name', 'price', 'quantity']);
          
      $data['agent'] = Member::where('id', $data['order']->agent_id)
                              ->get(['name']);




      $payment_method = $data['order']->payment_method;
      if($payment_method == 1) $data['payment_method'] = 'ATM Bersama';
      else if($payment_method == 4) $data['payment_method'] = 'Credit Card';

      if($xml->payment_status == 1) $data['status_payment'] = 'Pending';
      else if($xml->payment_status == 2) $data['status_payment'] = 'Paid';
      else if($xml->payment_status == 3) $data['status_payment'] = 'Failed';

      $member = Member::find($data['order']->customer_id);

      Mail::send('page.email', $data, function ($m) use ($member) {
          $m->from('gocgod@gocgod.com', 'noreply-gocgod');

          $m->to($member->email, $member->name)->subject('Pesanan Anda Telah Didaftarkan');
      });

      return view('page.summary', $data);
    }
    else
      return redirect('home');
  }

  public function getNotification(Request $data)
  {
    $xml = simplexml_load_string($data->getContent());
    
    $idOrder = filter_var($xml->idorder, FILTER_SANITIZE_STRING);

    $query = TxOrder::find($idOrder);
    $amount = $query->total;

    $signature = md5('gocgod' . 'gocgod123'. $idOrder . $amount);
    if($signature == $xml->signature)
    {
      $query->payment_method = filter_var($xml->payment_channel, FILTER_SANITIZE_STRING);
      $query->payment_account = filter_var($xml->idpaymentcode, FILTER_SANITIZE_STRING);
      $query->save();
    }

  }

  public function getResponse(Request $data)
  {
    $xml = simplexml_load_string($data->getContent());
    
    $idOrder = filter_var($xml->idorder, FILTER_SANITIZE_STRING);
    $paymentChannel = filter_var($xml->payment_channel, FILTER_SANITIZE_STRING);

    $query = TxOrder::find($idOrder);
    $amount = $query->total;

    $signature = md5('gocgod' . 'gocgod123'. $idOrder . $amount);

    //update database kalo dia belum bayar & payment channelnya sama
    if($signature == $xml->signature && $query->status_payment == 0 && $query->payment_method == $paymentChannel)
    {
      //berhasil
      if($xml->payment_status == 2)
      {
        $query->status_payment = 1;
      }
      else if($xml->payment_status == 3) //gagal
      {
        $query->status_payment = -1;
      }
      $query->save();
    }
  }

  //=============================== CHECKOUT SUBSCRIBER 

  public function addtocartsubcriber(Request $data)
  {
    $v = Validator::make($data->all(),[
      'qty' =>'required|numeric',
      ]);
    if($v->fails())
    {
      return "Not completed data";
    }

    $rowid = Cart::search(array('id' => $data->id));

    if($rowid){
      $item = Cart::get($rowid[0]);
      Cart::update($rowid[0], $item->qty + $data->qty);
    }
    else{
      Cart::add([
        'id'=> $data->id, 
        'qty' => $data->qty,
        'name' => $data->name,
        'price' => $data->price,
        ]);
    }
    $total = Cart::total();
    $response = array(
      'id' => $data->id,
      'qty' => $data->qty,
      'name' => $data->name,
      'price' => $data->price,
      'total' => $total
      );

    return response()->json(compact('response'));
  }

  public function updatecart(Request $data)
  {
    $v = Validator::make($data->all(),[
      'qty' =>'required|numeric',
      'id' =>'required',
      ]);

    if($v->fails())
    {
      return "Not completed data";
    }

    $qty = $data->qty;
    $rowid = $data->rowId; 
    $id = $data->id; 

    if ($qty <= 0) {
      return 'Quantity not valid';
    }else {
      $product = \DB::table('product__varian')->where('varian_id', $id)->first();
      Cart::update($data->rowId, $qty);
      $subtotal = $product->price * $qty;
      $total = Cart::total();

      $response = array(
        'subtotal' => $subtotal,
        'total' => $total);

      return response()->json(compact('response'));
    }
  }

  public function deletecart(Request $data)
  {
    $v = Validator::make($data->all(),[
      'qty' =>'required|numeric',
      ]);
    if($v->fails())
    {
      return "Not completed data";
    }
    Cart::remove($data->rowId);
    $total = Cart::total();

    $response = array(
      'total' => $total);

    return response()->json(compact('response'));
  }


  public function order_details(Request $data)
  {
    $totalProduct = count(Product::all());

    for ($i=0; $i < $totalProduct; $i++) { 
      $v = Validator::make($data->all(),[
        $i.'-name' =>'required',
        $i.'-id' =>'required|numeric',
        $i.'-price' =>'required|numeric',
        $i.'-qty_subcriber' =>'required|numeric',
      ]);
    }

    if($v->fails())
    {
      return redirect('checkout_subcriber')->with('error', 'Error. Data yang anda masukkan tidak valid');
    }

    $input = $data->all();

    //masukkin data ke cart
    for ($i=0; $i < $totalProduct; $i++) {
      if($input[$i.'-qty_subcriber'] > 0)
      {
        $id = filter_var($input[$i.'-id'], FILTER_SANITIZE_STRING);
        $qty = intval(filter_var($input[$i.'-qty_subcriber'], FILTER_SANITIZE_STRING));
        $name = filter_var($input[$i.'-name'], FILTER_SANITIZE_STRING);
        $price = floatval(filter_var($input[$i.'-price'], FILTER_SANITIZE_STRING));

        //cek kalo udh ada di cart, berarti tinggal update
        $rowid = Cart::search(array('id' => $id));

        if($rowid){
          $item = Cart::get($rowid[0]);
          Cart::update($rowid[0], $qty);
        }
        else{
          Cart::add([
          'id'=> $id, 
          'qty' => $qty,
          'name' => $name,
          'price' => $price,
          ]);
        }
      } 
    }

    /*$rowid = Cart::search(array('id' => $data->id));

    if($rowid){
      $item = Cart::get($rowid[0]);
      Cart::update($rowid[0], $item->qty + $data->qty);
    }
    else{
      Cart::add([
        'id'=> $data->id, 
        'qty' => $data->qty,
        'name' => $data->name,
        'price' => $data->price,
        ]);
    }*/

    $data['contact'] = AboutUs::first();
    $data['agent'] = Member::leftJoin('master__city as c', 'master__member.city_id', '=', 'c.city_id')
    ->where('status_user', 0)
    ->get();


    $start = "";
    date_default_timezone_set('Asia/Jakarta');
    if(date("l") == "Friday")
    {
      $now = strtotime(date("H:i"));
      $plusdate = date("H:i", strtotime('+20 minutes', $now));
      if($plusdate > "17:00")
      {
        $cutoff = CutOffDate::find(1);
        $today = new \DateTime(NULL);
        date_add($today,date_interval_create_from_date_string("+".$cutoff->cut_off." days"));
        $start = date_format($today,"Y-m-d");
      }
      else
      {
        $start = date("Y-m-d", strtotime( "next monday"));
      }
    }
    else 
    {
      if(date("l") == "Saturday")
      {
        $cutoff = CutOffDate::find(1);
        $today = new \DateTime(NULL);
        date_add($today,date_interval_create_from_date_string("+".($cutoff->cut_off - 1)." days"));
        $start = date_format($today,"Y-m-d");
      }
      else if(date("l") == "Sunday")
      {
        $cutoff = CutOffDate::find(1);
        $today = new \DateTime(NULL);
        date_add($today,date_interval_create_from_date_string("+".($cutoff->cut_off - 2)." days"));
        $start = date_format($today,"Y-m-d"); 
      }
      else
      {
        $start = date("Y-m-d", strtotime( "next monday"));
      }
    }
    
    $data['start'] = $start;


    $data['city'] = City::all();

    return view('page.checkout_subcriber_2', $data);
  }

  public function orderall(Request $request)
  {
    $v = Validator::make($request->all(),[
      'address' => 'required|max:500',
      'city' => 'required|numeric',
      'zipcode' => 'required|max:50',
      'agent' => 'required|numeric',
      'week' => 'required|numeric',
      'request_date' =>  'required|max:10',
      ]);

    if ($v->fails())
    {
      return redirect('checkout_subcriber_2/')->withErrors($v->errors())->withInput();
    }

    $input = $request->all();

    $customer_id = Auth::user()->id;
    $agent_id = filter_var($input['agent'], FILTER_SANITIZE_STRING);
    $ship_address = filter_var($input['address'], FILTER_SANITIZE_STRING);
    $ship_city_id = filter_var($input['city'], FILTER_SANITIZE_STRING);
    $zipcode = filter_var($input['zipcode'], FILTER_SANITIZE_STRING);
    $shipping_date = filter_var($input['request_date'], FILTER_SANITIZE_STRING);
    $week = filter_var($input['week'], FILTER_SANITIZE_STRING);
    $shipping_fee = 0;
    $who = 'subcriber';
    $total = Cart::total();

    $a = TxOrder::orderBy('group_id', 'desc')->first();
    $group;

    if(empty($a))
      $group = 1;
    else
    {
      $group = $a->group_id + 1;
    }    

    
    $date_shipping = new \DateTime($shipping_date);
    $date = date_format($date_shipping,"Y-m-d"); 

    date_default_timezone_set('Asia/Jakarta');
    $date_order = new  \DateTime();
    $order_date = date_format($date_order, "Y-m-d H:i:s");
    for($i = 0; $i < $week; $i++)
    {
      $order = new TxOrder;
      $order->customer_id = $customer_id;
      $order->agent_id = $agent_id;
      $order->ship_address = $ship_address;
      $order->ship_city_id = $ship_city_id;
      $order->zipcode = $zipcode;
      $order->shipping_date = $date;
      $order->group_id = $group;
      $order->shipping_fee = $shipping_fee;
      $order->total = $total + $shipping_fee;
      $order->who = $who;
      $order->order_date = $order_date;
      $order->save();
      date_add($date_shipping,date_interval_create_from_date_string("+7 days"));
      $date = date_format($date_shipping,"Y-m-d");

      foreach(Cart::content() as $subcriber)
      {
        $b = TxOrder::orderBy('order_id', 'desc')->first();
        $details = new TxOrderDetail;
        $details->order_id = $b->order_id;
        $details->varian_id = $subcriber->id;
        $details->varian_price = $subcriber->price;
        $details->quantity = $subcriber->qty;
        $details->save();
      }
    }
    Cart::destroy();
    

    if($input['payment'] == 0)
    {
      return redirect('/summary/'.$a->group_id);
    }
    else if($input['payment'] == 1)
    {
      return redirect('/#');
    }

  }

  public function summary($id)
  {
    $data['order'] = TxOrder::where('group_id', $id)->first();
    $data['orderprice'] = \DB::table('transaction__order')
                      ->select(\DB::raw('SUM(total) as total_price'))
                      ->groupBy('group_id')
                      ->having('group_id', '=', $id)
                      ->get();
                      
    $data['contact'] = AboutUs::first();

    $data['order_a'] = TxOrder::where('group_id', $id)->get();
    $data['orderdetails'] = TxOrderDetail::where('order_id', $data['order_a'][0]->order_id)
                            ->leftJoin('product__varian as pv', 'transaction__order_detail.varian_id', '=', 'pv.varian_id')
                            ->get(['varian_name', 'price', 'quantity']);
    $data['agent'] = Member::where('id', $data['order_a'][0]->agent_id)
                            ->get(['name']);


    Mail::send('page.email', $data, function ($m) {
        $m->from('gocgod@gocgod.com', 'noreply-gocgod');

        $m->to(Auth::user()->email, Auth::user()->name)->subject('Pesanan Anda Telah Didaftarkan');
    });

    return view('page.summary1', $data);

  }


  //================================== CUSTOMER ORDER DATA - AGENT
  public function getOrderList()
  {
    $data['contact'] = AboutUs::first();
    $data['active'] = 'txOrder';

    return view('page.customerorder', $data);
  }

  public function getOrderData(Request $request)
  {
    $data['query'] = TxOrder::leftJoin('master__member as c', 'customer_id', '=', 'c.id')
                            ->leftJoin('master__member as a', 'agent_id', '=', 'a.id')
                            ->leftJoin('master__city as city', 'city.city_id', '=', 'ship_city_id')
                            ->where('a.id', Auth::user()->id)
                            ->where('status_shipping', 0)
                            ->orderBy('shipping_date', 'asc')
                            ->get(['order_id', 'c.name as customer', 'shipping_date', 'ship_address', 'c.phone as phone','city_name', 'status_confirmed', 'status_shipping' ,'who']);
        


    return Datatables::of($data['query'])
    ->editColumn('status_payment', function($data){ 
        if($data->status_payment == 0) return "Belum dibayar";
        else if($data->status_payment == 1) return "Sudah dibayar";
    })
    ->editColumn('status_confirmed', function($data){ 
        if($data->status_confirmed == 0) return "Belum diterima";
        else if($data->status_confirmed == 1) return "Sudah diterima";
    })
    ->make(true);
  }

  public function getCurrentOrderList()
  {
    return view('page.agent_current_order');
  }

  public function getHistoryOrderList()
  {
    return view('page.agent_history_order');
  }

  public function getHistoryOrderData(Request $request)
  {
    $data['query'] = TxOrder::leftJoin('master__member as c', 'customer_id', '=', 'c.id')
                            ->leftJoin('master__member as a', 'agent_id', '=', 'a.id')
                            ->leftJoin('master__city as city', 'city.city_id', '=', 'ship_city_id')
                            ->where('a.id', Auth::user()->id)
                            ->where('status_shipping', 1)
                            ->orderBy('shipping_date', 'desc')
                            ->get(['order_id', 'c.name as customer', 'shipping_date', 'ship_address', 'c.phone as phone','city_name', 'status_confirmed', 'status_shipping' ,'who']);

    return Datatables::of($data['query'])
    ->editColumn('status_payment', function($data){ 
      if($data->status_payment == 0) return "Belum dibayar";
      else if($data->status_payment == 1) return "Sudah dibayar";
    })
    ->editColumn('status_confirmed', function($data){ 
      if($data->status_confirmed == 0) return "Belum diterima";
      else if($data->status_confirmed == 1) return "Sudah diterima";
    })
    ->make(true);
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
      $data = new ProductDataOrder();
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

  public function sending(Request $request)
  {
    $input = $request->all();
    $id = filter_var($input['id'], FILTER_SANITIZE_STRING);

    $order = Txorder::find($id);
    $order->status_shipping = 1;
    $order->save();

    return redirect('customerorder');
  }


  //================================== MY ORDER - CUSTOMER
  public function getOrderListCustomer()
  {
    $data['contact'] = AboutUs::first();
    $data['active'] = 'txOrder';
    return view('page.myorder', $data);
  }

  public function getOrderDataCustomer(Request $request)
  {

    $data['query'] = TxOrder::leftJoin('master__member as c', 'customer_id', '=', 'c.id')
    ->leftJoin('master__member as a', 'agent_id', '=', 'a.id')
    ->leftJoin('master__city as city', 'city.city_id', '=', 'ship_city_id')
                            // ->leftJoin('transaction__order_detail as order', 'order_id', '=', 'order.order_id')
    ->where('c.id', Auth::user()->id)
    ->where('status_confirmed', 0)
    ->get(['order_id', 'shipping_fee', 'total' ,'group_id', 'shipping_date', 'status_shipping', 'a.name as agent', 'c.name as customer', 'order_date', 'ship_address', 'city_name', 'status_payment', 'status_confirmed', 'who']);



    return Datatables::of($data['query'])
    ->editColumn('status_payment', function($data){ 
      if($data->status_payment == 0) return "Belum dibayar";
      else if($data->status_payment == 1) return "Sudah dibayar";
    })
    ->editColumn('status_shipping', function($data){ 
      if($data->status_shipping == 0) return "Sedang diproses";
      else if($data->status_shipping == 1) return "Sudah dikirim";
    })
    ->make(true);
  }

  public function getProductOrderCustomer(Request $request)
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
      $data = new ProductDataOrder();
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

  public function receive(Request $request)
  {
    $input = $request->all();
    $id = filter_var($input['id'], FILTER_SANITIZE_STRING);

    $order = Txorder::find($id);
    $order->status_confirmed = 1;
    $order->save();

    return redirect('customerorder');
  }

  public function postEditOrderCustomer(Request $request)
  {
    $v = Validator::make($request->all(), [
        'id' => 'required|numeric',
        'ship' => 'required'
    ]);

    $input = $request->all();

    $id = filter_var($input['id'], FILTER_SANITIZE_STRING);

    if ($v->fails())
    {
        return redirect('/edit/order' . '/' . $id)->withErrors($v->errors())->withInput();
    }    

    $ship = filter_var($input['ship'], FILTER_SANITIZE_STRING);

    
    $order = TxOrder::find($id);
    $order->shipping_date = $ship;
    $order->save();
    $detailorder = \DB::table('transaction__order_detail')
                  ->where('order_id', $id)
                  ->sum('quantity');
    // $total_price = \DB::table('transaction__order_detail')
    //   ->select(\DB::raw('sum(varian_price * quantity) AS price'))
    //   ->where('order_id', $id)
    //   ->first();
    $total_price = TxOrder::where('order_id', $id)
                ->get(['total']);     
    $total_product = Product::all();
    $orderdetail = TxOrderDetail::where('order_id', $id)->get();
    
    $array;
    $tmp_total=0;
    for($i=0, $j=0; $i<count($total_product); $i++)
    {
      $quantity = filter_var($input[$i.'-qty'], FILTER_SANITIZE_STRING);
      if($quantity > 0)
      {
        $tmp_total += ($quantity*$total_product[$i]->price);
        $array[$j++] = $i;
      }
    }

    if($tmp_total> $total_price[0]->total)
    {
      Session::flash('error', 1);
      return redirect('edit/order' . '/' . $id);
    }
    else
    {
      \DB::transaction(function() use ($id, $array, $total_product, $input)
      {
        TxOrderDetail::where('order_id', $id)
                      ->delete();

        foreach($array as $data){
          $quantity_a = filter_var($input[$data.'-qty'], FILTER_SANITIZE_STRING);
          $new = new TxOrderDetail;
          $new->order_id = $id;
          $new->varian_id =  $total_product[$data]->varian_id;
          $new->quantity = $quantity_a;
          $new->varian_price = $total_product[$data]->price;
          $new->save();

        }



        Session::flash('success', 1);
      });

    }

    return redirect('myorder');
  }

  public function getEditOrderCustomer($id)
  {
    $data['contact'] = AboutUs::first();
    $id = filter_var($id, FILTER_SANITIZE_STRING);
    $query = TxOrder::find($id);


    $sunday = date("Y-m-d", strtotime("sunday"));
    $sunday = new \DateTime($sunday);

    $ship = new \DateTime($query->shipping_date);
    
    if($ship <= $sunday)
      return redirect('myorder');
    else
    {
      $data['query'] = $query;

      $ship = date_format($ship,"Y-m-d");
      $data['monday'] = date('Y-m-d', strtotime("-7 days", strtotime("next monday", strtotime($ship))));
      $data['sunday'] = date('Y-m-d', strtotime("+6 days", strtotime($data['monday'])));
      $data['name_product'] = TxOrder::leftJoin('transaction__order_detail as od', 'transaction__order.order_id', '=', 'od.order_id')
                              ->leftJoin('product__varian as pv', 'od.varian_id','=', 'pv.varian_id')
                              ->where('od.order_id', $id)
                              ->get(['pv.varian_name as vn','od.varian_id as varian_id', 'pv.price as price', 'od.quantity as qty']);
      $data['total_quantity'] = \DB::table('transaction__order_detail')
                  ->where('order_id', $id)
                  ->sum('quantity');
      $data['total_price'] = TxOrder::where('order_id', $id)
                              ->get(['total']);
      $data['product_all'] = Product::all();
      
      return view('page.customer_edit_order', $data);
    }
  }

  //=========================== HISTORY ORDER
  public function getOrderListHistoryCustomer()
  {
    $data['contact'] = AboutUs::first();
    $data['active'] = 'txOrder';

    return view('page.historymyorder', $data);
  }

  public function getOrderDataHistoryCustomer(Request $request)
  {

    $data['query'] = TxOrder::leftJoin('master__member as c', 'customer_id', '=', 'c.id')
    ->leftJoin('master__member as a', 'agent_id', '=', 'a.id')
    ->leftJoin('master__city as city', 'city.city_id', '=', 'ship_city_id')
    ->where('status_confirmed', 1)
    ->where('status_shipping', 1)
    ->get(['order_id', 'shipping_fee', 'total' ,'group_id', 'shipping_date', 'status_shipping', 'a.name as agent', 'c.name as customer', 'order_date', 'ship_address', 'city_name', 'status_payment', 'status_confirmed', 'who', 'total']);



    return Datatables::of($data['query'])
    ->editColumn('status_payment', function($data){ 
      if($data->status_payment == 0) return "Unpaid";
      else if($data->status_payment == 1) return "Paid";
    })
    ->editColumn('status_shipping', function($data){ 
      if($data->status_shipping == 0) return "Processed";
      else if($data->status_shipping == 1) return "Sent";
    })
    ->make(true);
  }

  public function getProductOrderHistoryCustomer(Request $request)
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
      $data = new ProductDataOrder();
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
}
