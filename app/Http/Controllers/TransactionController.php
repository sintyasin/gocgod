<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Auth;
use Cart;
use App\Http\Requests;
use App\Product;
use App\ProductCategory;
use App\NameProduct;
use App\ProductTestimonial;
use App\Member;
use App\Balance;
use App\TxOrder;
use App\TxOrderDetail;
use Yajra\Datatables\Datatables;
use App\City;

class ProductDataOrder
{
public $name;
public $quantity;
public $price;
}

//=========================== CHECKOUT SINGLE
class TransactionController extends Controller
{
  public function order_details_single()
  {
    $data['agent'] = Member::leftJoin('master__city as c', 'master__member.city_id', '=', 'c.city_id')
    ->where('status_user', 0)
    ->get();

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

    Cart::instance('single')->add([
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
      Cart::instance('single')->update($data->rowId, $qty);
      $subtotal = $product->price * $qty;
      $total = Cart::instance('single')->total();

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
    Cart::instance('single')->remove($data->rowId);
    $total = Cart::instance('single')->total();

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
    $shipping_date = filter_var($input['request_date'], FILTER_SANITIZE_STRING);
    $shipping_fee = 10000;
    $who = 'single';
    $total = Cart::instance('single')->total();

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

    $order = new TxOrder;
    $order->customer_id = $customer_id;
    $order->agent_id = $agent_id;
    $order->ship_address = $ship_address;
    $order->ship_city_id = $ship_city_id;
    $order->shipping_date = $date;
    $order->group_id = $group;
    $order->shipping_fee = $shipping_fee;
    $order->total = $total + $shipping_fee;
    $order->who = $who;
    $order->save();
   

    foreach(Cart::instance('single')->content() as $single)
    {
      $b = TxOrder::orderBy('order_id', 'desc')->first();
      $details = new TxOrderDetail;
      $details->order_id = $b->order_id;
      $details->varian_id = $single->id;
      $details->varian_price = $single->price;
      $details->quantity = $single->qty;
      $details->save();
    }

    Cart::instance('single')->destroy();
    return redirect('/myorder');

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
    $rowid = Cart::instance('subcriber')->search(array('id' => $data->id));

    if($rowid){
      $item = Cart::instance('subcriber')->get($rowid[0]);
      Cart::instance('subcriber')->update($rowid[0], $item->qty + $data->qty);
    }
    else{
      Cart::instance('subcriber')->add([
        'id'=> $data->id, 
        'qty' => $data->qty,
        'name' => $data->name,
        'price' => $data->price,
        ]);
    }
    $total = Cart::instance('subcriber')->total();
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
      Cart::instance('subcriber')->update($data->rowId, $qty);
      $subtotal = $product->price * $qty;
      $total = Cart::instance('subcriber')->total();

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
    Cart::instance('subcriber')->remove($data->rowId);
    $total = Cart::instance('subcriber')->total();

    $response = array(
      'total' => $total);

    return response()->json(compact('response'));
  }


  public function order_details()
  {
    $data['agent'] = Member::leftJoin('master__city as c', 'master__member.city_id', '=', 'c.city_id')
    ->where('status_user', 0)
    ->get();

    $data['city'] = City::all();

    return view('page.checkout_subcriber_2', $data);
  }

  public function orderall(Request $request)
  {
    $v = Validator::make($request->all(),[
      'address' => 'required|max:500',
      'city' => 'required|numeric',
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
    $shipping_date = filter_var($input['request_date'], FILTER_SANITIZE_STRING);
    $week = filter_var($input['week'], FILTER_SANITIZE_STRING);
    $shipping_fee = 10000;
    $who = 'subcriber';
    $total = Cart::instance('subcriber')->total();

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

    for($i = 0; $i < $week; $i++)
    {
      $order = new TxOrder;
      $order->customer_id = $customer_id;
      $order->agent_id = $agent_id;
      $order->ship_address = $ship_address;
      $order->ship_city_id = $ship_city_id;
      $order->shipping_date = $date;
      $order->group_id = $group;
      $order->shipping_fee = $shipping_fee;
      $order->total = $total + $shipping_fee;
      $order->who = $who;
      $order->save();
      date_add($date_shipping,date_interval_create_from_date_string("+7 days"));
      $date = date_format($date_shipping,"Y-m-d");

      foreach(Cart::instance('subcriber')->content() as $subcriber)
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
    Cart::instance('subcriber')->destroy();
    return redirect('/myorder');

  }


  //================================== CUSTOMER ORDER DATA - AGENT
  public function getOrderList()
  {
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
        if($data->status_payment == 0) return "Unpaid";
        else if($data->status_payment == 1) return "Paid";
    })
    ->editColumn('status_confirmed', function($data){ 
        if($data->status_confirmed == 0) return "Unconfirmed";
        else if($data->status_confirmed == 1) return "Confirmed";
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
      if($data->status_payment == 0) return "Unpaid";
      else if($data->status_payment == 1) return "Paid";
    })
    ->editColumn('status_confirmed', function($data){ 
      if($data->status_confirmed == 0) return "Unconfirmed";
      else if($data->status_confirmed == 1) return "Confirmed";
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
    //dd($id);

    $order = Txorder::find($id);
    $order->status_shipping = 1;
    $order->save();

    return redirect('customerorder');


  }


  //================================== MY ORDER - CUSTOMER
  public function getOrderListCustomer()
  {
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
      if($data->status_payment == 0) return "Unpaid";
      else if($data->status_payment == 1) return "Paid";
    })
    ->editColumn('status_shipping', function($data){ 
      if($data->status_shipping == 0) return "Processed";
      else if($data->status_shipping == 1) return "Sent";
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
    //dd($id);

    $order = Txorder::find($id);
    $order->status_confirmed = 1;
    $order->save();

    return redirect('customerorder');


  }

  public function postEditOrderCustomer(Request $request)
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

    $query = TxOrder::find($id);
    //dd($query);
    return $this->getEditOrderCustomer($query);
  }

  public function getEditOrderCustomer($id)
  {
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
      

      return view('page.customer_edit_order', $data);
    }
  }

  //=========================== HISTORY ORDER
  public function getOrderListHistoryCustomer()
  {
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
