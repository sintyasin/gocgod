<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Auth;
use Cart;
use Response;
use Redirect;
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
use App\AgentRating;
use App\TxOrderConfirmation;
use App\AgentFee;
use App\Province;
use App\District;

class ProductDataOrder
{
    public $name;
    public $quantity;
    public $price;
}

class TransactionController extends Controller
{
    public function get_city(Request $request)
    {
      $v = Validator::make($request->all(),[
          'id' =>'required|numeric',
        ]);

      if($v->fails())
        {
            return "Not completed data";
        }

      $input = $request->all();
      $id = filter_var($input['id'], FILTER_SANITIZE_STRING);
      $data['city'] = City::where('province_id', $id)->where('status', 1)->get();
      return view('page.city', $data);
    }

    public function get_district(Request $request)
    {
      $v = Validator::make($request->all(),[
          'id' =>'required|numeric',
        ]);

      if($v->fails())
        {
            return "Not completed data";
        }

      $input = $request->all();
      $id = filter_var($input['id'], FILTER_SANITIZE_STRING);
      $data['district'] = District::where('city_id', $id)->where('status', 1)->get();

      return view ('page.district', $data);
    }

    public function customerCart()
    {
        return view('page.customercart');
    }
    
    //=========================== CHECKOUT SINGLE ===========================
    //---------------- SEKALI BELI - add cart -----------------
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

    //---------------- SEKALI BELI - Update Cart -----------------
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
        }
        else {
            $product = \DB::table('product__varian')->where('varian_id', $id)->first();
            Cart::update($data->rowId, $qty);
            $subtotal = $product->price * $qty;
            $total = Cart::total();
            $qty = Cart::count();
            if($qty < 5) $shipping_fee = 10000;
            else $shipping_fee = 0;

            $response = array(
              'subtotal' => $subtotal,
              'total' => $total,
              'shipping_fee' => $shipping_fee,
              'qty' => $qty);

            return response()->json(compact('response'));
        }
    }

    //---------------- SEKALI BELI - Delete Cart -----------------
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
        $qty = Cart::count();
        if($qty < 5) $shipping_fee = 10000;
        else $shipping_fee = 0;

        $response = array(
            'total' => $total,
            'shipping_fee' => $shipping_fee,
            'qty' => $qty);

        return response()->json(compact('response'));
    }

    //---------------- SEKALI BELI - Page isi Data -----------------
    public function order_details_single(Request $request)
    {
        $data['contact'] = AboutUs::first();
        $data['agent'] = Member::leftJoin('master__city as c', 'master__member.city_id', '=', 'c.city_id')
                        ->where('status_user', 0)
                        ->get();
        $data['province'] = Province::where('status', 1)->get();
        $data['city'] = City::where('province_id', Auth::user()->province_id)->get();
        $data['district'] = District::where('city_id', Auth::user()->city_id)->get();

        $data['shipping_fee'] = 0;
        if(Cart::count() < 5)
        {
            $data['shipping_fee'] = 10000;
        }
        
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

        if($request->wantsJson())
        {
            $response = array(
                'type' => 'OK-SINGLE Page isi data',
                'data' => array($data['agent'], $data['start'], $data['city']));
            return Response::json(compact('response'));
        }

        return view('page.checkout_single', $data);
    }

    //---------------- SEKALI BELI - Ambil isi Data -----------------
    public function order_single(Request $request)
    {
        $v = Validator::make($request->all(),[
            'address' => 'required|max:500',
            'province' => 'required|numeric',
            'district' => 'required|numeric',
            'city' => 'required|numeric',
            'request_date' =>  'required|max:10',
            'zipcode' => 'required|numeric',
            ]);

        if ($v->fails())
        {
            return redirect('checkout_singlebuyer/')->withErrors($v->errors())->withInput()->with('error', 'Error. Data yang anda masukkan tidak valid');
        }

        $input = $request->all();

        $customer_id = Auth::user()->id;
        $ship_address = filter_var($input['address'], FILTER_SANITIZE_STRING);
        $province_id = filter_var($input['province'], FILTER_SANITIZE_STRING);
        $district_id = filter_var($input['district'], FILTER_SANITIZE_STRING);
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

        $group = rand();
        $date_shipping = new \DateTime($shipping_date);
        $date = date_format($date_shipping,"Y-m-d"); 

        date_default_timezone_set('Asia/Jakarta');
        $date_order = new  \DateTime();
        $order_date = date_format($date_order, "Y-m-d H:i:s");

        if(Auth::user()->status_user == 0) //kalo dia agen, berarti ordernya ke diri dia sendiri
            $agent_id = Auth::user()->id;
        else
        {
            $available_agent = Member::leftJoin('master__agent_ship as s', 'id', '=', 's.agent_id')
                          ->leftJoin('master__agent_day as d', 'id', '=', 'd.agent_id')
                          ->where('s.district_id', $district_id)
                          ->where('d.day', date('N', strtotime($shipping_date)))
                          ->get(['id']);
                          // dd($available_agent);
            if(!$available_agent->isEmpty())
            {
                for ($i=0; $i < count($available_agent); $i++) { 
                    $array[$i] = $available_agent[$i]->id;
                }
                //cari agen yg belum pernah dapet order
                $null_orderid = Member::leftJoin('transaction__order as to', 'master__member.id', '=', 'to.agent_id')
                                ->select('id', 'order_id')
                                ->whereIn('id', $array)
                                ->where('order_id', NULL)
                                ->groupBy('id')
                                ->first();

                //kalo ada yg belum pernah dapet order, dia langsung dapet order
                if(!is_null($null_orderid))
                {
                    $agent_id = $null_orderid->id;
                }
                else
                {
                    $agent = TxOrder::select('agent_id')
                                   ->whereIn('agent_id', $array)
                                   ->groupBy('agent_id') 
                                   ->orderBy(\DB::raw('MAX(order_id)'), 'asc')
                                   ->first();

                    $agent_id = $agent->agent_id;
                }
            }
            else 
                $agent_id = 0;
        }
        
        $order = new TxOrder;
        $order->customer_id = $customer_id;
        $order->agent_id = $agent_id;
        $order->ship_address = $ship_address;
        $order->ship_city_id = $ship_city_id;
        $order->province_id = $province_id;
        $order->district_id = $district_id;
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

        if(is_null($order->payment_method))//firstpay
            return redirect('/payment/confirm/'.$order->order_id);
        else if($order->payment_method == 0) //kalo bank transfer langsung ke payment
            return redirect('/payment/'.$order->order_id);
    }

    //---------------- SEKALI BELI - Bank Transfer Page Konfirmasi -----------------
    public function banktransfer(Request $request, $id)
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

        Mail::send('page.email_order', $data, function ($m) {
            $m->from('gocgod@gocgod.com', 'noreply-gocgod');

            $m->to(Auth::user()->email, Auth::user()->name)->subject('Pesanan Anda Telah Didaftarkan');
        });

        if($request->wantsJson())
        {
            $response = array(
                'type' => 'OK-SINGLE Konfirmasi Page Bank Transfer',
                'data' => array($data['order'], $data['orderdetail'], $data['order_a'], 
                    $data['orderprice'], $data['orderdetails'], $data['agent'], $data['status_payment'], $data['payment_method']));
            return Response::json(compact('response'));
        }

        return view('page.summary', $data);
    }

    //---------------- SEKALI BELI - First Pay Page Konfirmasi -----------------
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

    //=============================================================================
    //========================== REDIRECT DARI FIRSTPAY ===========================
    //=============================================================================
    public function payment(Request $request)
    {
        $input = $request->all();
        $id = filter_var($input['idorder'], FILTER_SANITIZE_STRING);

        $data['order'] = TxOrder::where('group_id', $id)->first();
        $data['status_payment'] = '';
        $data['payment_method'] = '';

        $amount = $data['order']->total;
        $signature = md5('gocgod' . 'gocgod123'. $id . $amount);

        if($signature == $input['signature'])
        {
            $data['orderdetail'] = \DB::table('transaction__order_detail')
                                    ->select(\DB::raw('SUM(quantity) as quantity'))
                                    ->groupBy('order_id')
                                    ->get();
            $data['contact'] = AboutUs::first();
            $data['order_a'] = TxOrder::where('group_id', $id)->get();
            $data['orderprice'] = \DB::table('transaction__order')
                                  ->select('total as total_price')
                                  ->where('group_id', '=', $id)
                                  ->get();

            $data['orderdetails'] = TxOrderDetail::where('order_id', $data['order']->order_id)
                                    ->leftJoin('product__varian as pv', 'transaction__order_detail.varian_id', '=', 'pv.varian_id')
                                    ->get(['varian_name', 'price', 'quantity']);
                
            $data['agent'] = Member::where('id', $data['order']->agent_id)
                              ->get(['name']);

            $data['week'] = TxOrder::where('group_id', $id)->count();
            $data['totalperweek'] = $data['order']->total / $data['week'];

            $payment_method = $data['order']->payment_method;
            if($payment_method == 1) 
            {
                $data['payment_method'] = 'ATM Bersama';
                $data['bankcode'] = $data['order']->bank_code;
                $data['paymentaccount'] = $data['order']->payment_account;
            }
            else if($payment_method == 4) $data['payment_method'] = 'Credit Card';

            if($input['payment_status'] == 1) $data['status_payment'] = 'Pending';
            else if($input['payment_status'] == 2) $data['status_payment'] = 'Paid';
            else if($input['payment_status'] == 3) $data['status_payment'] = 'Failed';

            $member = Member::find($data['order']->customer_id);

            Mail::send('page.email_order', $data, function ($m) use ($member) {
                $m->from('gocgod@gocgod.com', 'noreply-gocgod');

                $m->to($member->email, $member->name)->subject('Pesanan Anda Telah Didaftarkan');
            });

            return view('page.summary', $data);
        }
        else
            return redirect('home');
    }

    public function getResponse(Request $data)
    {
        $xml = simplexml_load_string($data->getContent());
        
        $idOrder = filter_var($xml->idorder, FILTER_SANITIZE_STRING);

        $query = TxOrder::where('group_id', $idOrder)->get();
        $amount = $query[0]->total;

        $signature = md5('gocgod' . 'gocgod123'. $idOrder . $amount);

        //update database kalo dia belum bayar & payment channelnya sama
        if($signature == $xml->signature)
        {
            foreach ($query as $order)
            {
              //pending
                if($xml->payment_status == 1)
                {
                    $order->payment_method = filter_var($xml->payment_channel, FILTER_SANITIZE_STRING);
                    $order->payment_account = filter_var($xml->idpaymentcode, FILTER_SANITIZE_STRING);
                    $order->bank_code = filter_var($xml->idbankcode, FILTER_SANITIZE_STRING);
                    $order->save();
                }
                else if($xml->payment_status == 2) //berhasil
                {
                    $order->status_payment = 1;
                }
                else if($xml->payment_status == 3) //gagal
                {
                    $order->status_payment = -1;
                }
                $order->save(); 
            }  
            echo "CONTINUE";
        }
    }

    //=============================== CHECKOUT SUBSCRIBER =============================== 
    //---------------- BERLANGGANAN - update cart -----------------
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
            $qty = Cart::count();

            $response = array(
              'subtotal' => $subtotal,
              'total' => $total,
              'qty' => $qty);

            return response()->json(compact('response'));
        }
    }

    //---------------- BERLANGGGANAN - delete cart -----------------
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
        $qty = Cart::count();

        $response = array(
            'total' => $total,
            'qty' => $qty);

        return response()->json(compact('response'));
    }

    //---------------- BERLANGGANAN - add to cart  -----------------
    public function addtocartSubscribe(Request $data)
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
            return 0;
        }

        $input = $data->all();

        //masukkin data ke cart
        for ($i=0; $i < $totalProduct; $i++) {
            $id = filter_var($input[$i.'-id'], FILTER_SANITIZE_STRING);
            
            if($input[$i.'-qty_subcriber'] > 0)
            {
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
            else
            {
                $rowid = Cart::search(array('id' => $id));

                if($rowid){
                    Cart::remove($rowid[0]);
                }
            }
        }
        return 1;
    }

    //---------------- BERLANGGANAN - Page isi data  -----------------
    public function order_details(Request $request)
    {
        $data['contact'] = AboutUs::first();
        $data['agent'] = Member::leftJoin('master__city as c', 'master__member.city_id', '=', 'c.city_id')
                        ->where('status_user', 0)
                        ->get();

        $data['province'] = Province::where('status', 1)->get();
        $data['city'] = City::where('province_id', Auth::user()->province_id)->get();
        $data['district'] = District::where('city_id', Auth::user()->city_id)->get();

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

        if($request->wantsJson())
        {
            $response = array(
                'type' => 'OK-SUBSCRIBE Page isi data',
                'data' => array($data['agent'], $data['start'], $data['city']));
            return Response::json(compact('response'));
        }
        return view('page.checkout_subcriber_2', $data);
    }

    //---------------- BERLANGGANAN - Ambil isi data  -----------------
    public function orderall(Request $request)
    {
        $v = Validator::make($request->all(),[
          'address' => 'required|max:500',
          'province' => 'required|numeric',
          'district' => 'required|numeric',
          'city' => 'required|numeric',
          'zipcode' => 'required|max:50',
          'week' => 'required|numeric',
          'request_date' =>  'required|max:10',
          ]);

        if ($v->fails())
        {
            return redirect('orderall_checkout')->with('error', 'Error. Data yang anda masukkan tidak valid')->withErrors($v->errors())->withInput();
        }

        $input = $request->all();

        $customer_id = Auth::user()->id;
        $ship_address = filter_var($input['address'], FILTER_SANITIZE_STRING);
        $province_id = filter_var($input['province'], FILTER_SANITIZE_STRING);
        $district_id = filter_var($input['district'], FILTER_SANITIZE_STRING);
        $ship_city_id = filter_var($input['city'], FILTER_SANITIZE_STRING);
        $zipcode = filter_var($input['zipcode'], FILTER_SANITIZE_STRING);
        $shipping_date = filter_var($input['request_date'], FILTER_SANITIZE_STRING);
        $week = intval(filter_var($input['week'], FILTER_SANITIZE_STRING));
        $shipping_fee = 0;
        $who = 'subscriber';
        $total = Cart::total() * $week;


        $a = TxOrder::orderBy('group_id', 'desc')->first();
        $group;

        if(empty($a)) $group = 1;
        else
        {
            $group = $a->group_id + 1;
        }    

        $group = rand();
        
        $date_shipping = new \DateTime($shipping_date);
        $date = date_format($date_shipping,"Y-m-d"); 

        date_default_timezone_set('Asia/Jakarta');
        $date_order = new  \DateTime();
        $order_date = date_format($date_order, "Y-m-d H:i:s");

        if(Auth::user()->status_user == 0) //kalo dia agen, berarti ordernya ke diri dia sendiri
            $agent_id = Auth::user()->id;
        else
        {
            $available_agent = Member::leftJoin('master__agent_ship as s', 'id', '=', 's.agent_id')
                          ->leftJoin('master__agent_day as d', 'id', '=', 'd.agent_id')
                          ->where('s.district_id', $district_id)
                          ->where('d.day', date('N', strtotime($shipping_date)))
                          ->get(['id']);

            if(!$available_agent->isEmpty())
            {
                for ($i=0; $i < count($available_agent); $i++) { 
                    $array[$i] = $available_agent[$i]->id;
                }
                //cari agen yg belum pernah dapet order
                $null_orderid = Member::leftJoin('transaction__order as to', 'master__member.id', '=', 'to.agent_id')
                                ->select('id', 'order_id')
                                ->whereIn('id', $array)
                                ->where('order_id', NULL)
                                ->groupBy('id')
                                ->first();

                //kalo ada yg belum pernah dapet order, dia langsung dapet order
                if(!is_null($null_orderid))
                {
                    $agent_id = $null_orderid->id;
                }
                else
                {
                    $agent = TxOrder::select('agent_id')
                                   ->whereIn('agent_id', $array)
                                   ->groupBy('agent_id')
                                   ->orderBy(\DB::raw('MAX(order_id)'), 'asc')
                                   ->first();

                    $agent_id = $agent->agent_id;
                }
            }
            else 
                $agent_id = 0;
        }

        for($i = 0; $i < $week; $i++)
        {
            $order = new TxOrder;
            $order->customer_id = $customer_id;
            $order->agent_id = $agent_id;
            $order->ship_address = $ship_address;
            $order->ship_city_id = $ship_city_id;
            $order->province_id = $province_id;
            $order->district_id = $district_id;
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
            return redirect('/payment/subscribe/' . $order->group_id);
        }
        else if($input['payment'] == 1)
        {
            return redirect('/payment/subscribe/confirm/' . $order->group_id);
        }
    }

    //---------------- BERLANGGANAN -  Bank Transfer Page Konfirmasi  -----------------
    public function banktransferSubscribe(Request $request, $Gid)
    {
        $data['order'] = TxOrder::where('group_id', $Gid)->first();
        $data['orderprice'] = \DB::table('transaction__order')
                          ->select('total as total_price')
                          ->groupBy('group_id')
                          ->having('group_id', '=', $Gid)
                          ->get();
                          
        $data['week'] = TxOrder::where('group_id', $Gid)->count();
        $data['totalperweek'] = $data['order']->total / $data['week'];

        $data['contact'] = AboutUs::first();

        $data['order_a'] = TxOrder::where('group_id', $Gid)->get();
        $data['orderdetails'] = TxOrderDetail::where('order_id', $data['order_a'][0]->order_id)
                                ->leftJoin('product__varian as pv', 'transaction__order_detail.varian_id', '=', 'pv.varian_id')
                                ->get(['varian_name', 'price', 'quantity']);
        $data['agent'] = Member::where('id', $data['order_a'][0]->agent_id)
                                ->get(['name']);

        $data['status_payment'] = 'Pending';
        $data['payment_method'] = 'Bank Transfer';

        Mail::send('page.email_order', $data, function ($m) {
            $m->from('gocgod@gocgod.com', 'noreply-gocgod');

            $m->to(Auth::user()->email, Auth::user()->name)->subject('Pesanan Anda Telah Didaftarkan');
        });

        if($request->wantsJson())
        {
            $response = array(
                'type' => 'OK-SUBSCRIBE Konfirmasi Page Bank Transfer',
                'data' => array($data['order'], $data['orderprice'], $data['week'], 
                    $data['totalperweek'], $data['order_a'], $data['orderdetails'], $data['agent'], $data['status_payment'], $data['payment_method']));
            return Response::json(compact('response'));
        }

        return view('page.summary', $data);
    }

    //---------------- BERLANGGANAN -  First Pay Page Konfirmasi  -----------------
    public function paymentConfirmSubscribe($groupId)
    {
        $data['order'] = TxOrder::where('group_id', $groupId)->first();
        $data['total'] = \DB::table('transaction__order')
                          ->select('total as total_price')
                          ->groupBy('group_id')
                          ->having('group_id', '=', $groupId)
                          ->get();

        $data['contact'] = AboutUs::first();
        
        $query = Member::where('id', $data['order']->customer_id)
                                      ->leftJoin('master__city as c', 'c.city_id', '=', 'master__member.city_id')
                                      ->get(['city_name']);


        $data['customerCity'] = $query[0]->city_name;

        $signature = 'gocgod' . 'gocgod123' . $groupId . $data['total'][0]->total_price;
        
        $data['signature'] = md5($signature);
            
        return view('page.paymentconfirm', $data);
    }

    //================================== CUSTOMER ORDER DATA - AGENT ==================================
    //---------------- Pesanan Pelanggan - Page Utama  -----------------
    public function getOrderList(Request $request)
    {
        $data['contact'] = AboutUs::first();
        $data['active'] = 'txOrder';

        return view('page.customerorder', $data);
    }

    //---------------- Pesanan PPelanggan - Datatable  -----------------
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

        // if($request->wantsJson())
        // {
        //     $response = array(
        //         'type' => 'OK-Pesananku Datatable',
        //         'data' => $data['query']);
        //     return Response::json(compact('response'));
        // }
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

    public function getOrder(Request $request)
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

      $order = TxOrder::find($id);

      if(isset($order))
      {
        $json = json_encode($order);

        return $json;
      }
      else return 0;

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
      ->leftJoin('transaction__order_confirmation as oc', 'oc.group_id', '=', 'transaction__order.group_id')
      ->where('c.id', Auth::user()->id)
      ->where(function ($query) {
                  $query->where('status_confirmed', '!=', 1)
                        ->orWhere('confirmation_status', '!=', 1);
              })
      ->get(['order_id', 'shipping_fee', 'total' ,'transaction__order.group_id', 'shipping_date', 'status_shipping', 'a.id as agent_id', 'a.name as agent', 'c.name as customer', 'order_date', 'ship_address', 'city_name', 'status_payment', 'status_confirmed', 'who', 'oc.group_id as idid','confirmation_status']);

      return Datatables::of($data['query'])
      ->editColumn('status_payment', function($data){ 
        if($data->status_payment == 0 && $data->confirmation_status == 0) return "Belum dibayar";
        else if($data->status_payment == 1 || $data->confirmation_status == 1) return "Sudah dibayar";
      })
      ->editColumn('status_shipping', function($data){ 
        if($data->status_shipping == 0) return "Sedang diproses";
        else if($data->status_shipping == 1) return "Sudah dikirim";
      })
      ->editColumn('confirmation_status', function($data){ 
        if($data->confirmation_status == 0) return "0";
        else if($data->confirmation_status == 1) return "1";
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

      $v = Validator::make($request->all(), [
        'id' => 'required',
        'agent_id' => 'required',
        'rating' => 'required|numeric'
        ]);

      $input = $request->all();
      $id = filter_var($input['id'], FILTER_SANITIZE_STRING);
      $agent_id = filter_var($input['agent_id'], FILTER_SANITIZE_STRING);
      $rate = intval(filter_var($input['rating'], FILTER_SANITIZE_STRING));
      $review = filter_var($input['review'], FILTER_SANITIZE_STRING);
      $cust_id = filter_var(Auth::user()->id, FILTER_SANITIZE_STRING);
      

      \DB::transaction(function() use ($id, $agent_id, $rate, $review, $cust_id)
      {
        $order = Txorder::find($id);
        $order->status_confirmed = 1;
        $order->save();

        $percent = AgentFee::first();

        $count = TxOrder::where('group_id', $order->group_id)->count();
        $total = (($order->total - $order->shipping_fee) / $count ) * ($percent->fee / 100);

        $balance = new Balance;
        $balance->agent_id = $order->agent_id;
        $balance->amountMoney = $total;
        $balance->balance_type = 1;
        $balance->order_id = $order->order_id;
        $balance->statusTransfer = 0;
        $balance->save();

        $agent = Member::find($order->agent_id);
        $agent->balance = $agent->balance + $total;
        $agent->save();
        
        $rating = new AgentRating;
        $rating->agent_id = $agent_id;
        $rating->customer_id = $cust_id;
        $rating->rating = $rate;
        $rating->comment = $review;
        $rating->save();
      });

      return redirect('customerorder');
    }

    public function confirmation_pay(Request $request)
    {
      $v = Validator::make($request->all(), [
          'id_pay' => 'required',
          'total' => 'required|numeric',
          'pay_accountname' => 'required',
          'pay_accountnumber' => 'required|numeric',
          'pay_amount' => 'required|numeric',
          'payment_date' => 'required',
      ]);

      $input = $request->all();

      $group_id = filter_var($input['id_pay'], FILTER_SANITIZE_STRING);
      $payment_date = filter_var($input['payment_date'], FILTER_SANITIZE_STRING);
      $account_name = filter_var($input['pay_accountname'], FILTER_SANITIZE_STRING);
      $account_number = filter_var($input['pay_accountnumber'], FILTER_SANITIZE_STRING);
      $total = intval(filter_var($input['total'], FILTER_SANITIZE_STRING));
      $amount = intval(filter_var($input['pay_amount'], FILTER_SANITIZE_STRING));

      if($amount < $total)
      {
        return redirect('/myorder/')->with('error', 'Jumlah uang kurang, silahkan cek kembali total pembelanjaan Anda');
      }
      else
      {
        $confirm = new TxOrderConfirmation;
        $confirm->group_id = $group_id;
        $confirm->payment_date = $payment_date;
        $confirm->account_name = $account_name;
        $confirm->account_number = $account_number;
        $confirm->amount = $amount;
        $confirm->save();

        return redirect('/myorder/')->with('ok', 'Konfirmasi pembayaran akan segera di proses!');
      }

    }  

    public function getEditOrderCustomer($id)
    {
      $data['contact'] = AboutUs::first();
      $id = filter_var($id, FILTER_SANITIZE_STRING);
      $query = TxOrder::find($id);

      date_default_timezone_set('Asia/Jakarta');
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

        $order = TxOrder::find($id);
        $count = TxOrder::where('group_id', $order->group_id)->count();

        $data['total_price'] = ($order->total - $order->shipping_fee) / $count;
        $data['product_all'] = Product::all();
        
        return view('page.customer_edit_order', $data);
      }
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

      //cek dulu dia masukkin datanya sesuai range minggu itu / engga
      date_default_timezone_set('Asia/Jakarta');
      $date = date_format(new \DateTime($order->shipping_date), "Y-m-d");

      $monday = date('Y-m-d', strtotime("-7 days", strtotime("next monday", strtotime($date))));
      $sunday = date('Y-m-d', strtotime("+6 days", strtotime($monday)));
      
      if($ship < $monday || $ship > $sunday)
        return redirect('/edit/order' . '/' . $id)->with('dateError', 'Tanggal pengiriman yang baru harus dalam minggu yang sama dengan tanggal pengiriman sebelumnya!');

      $order->shipping_date = $ship;
      $order->save();
      $detailorder = \DB::table('transaction__order_detail')
                    ->where('order_id', $id)
                    ->sum('quantity');
      // $total_price = \DB::table('transaction__order_detail')
      //   ->select(\DB::raw('sum(varian_price * quantity) AS price'))
      //   ->where('order_id', $id)
      //   ->first();
      
      //cek dulu dia ada brapa transaksi
      $count = TxOrder::where('group_id', $order->group_id)->count();
      $total_price = ($order->total - $order->shipping_fee) / $count;

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

      if($tmp_total> $total_price)
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

          Session::flash('success', 'Pesanan ID ' . $id . ' berhasil diubah!');
        });

      }

      return redirect('myorder');
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
        if($data->status_payment == 0) return "Belum Dibayar";
        else if($data->status_payment == 1) return "Sudah Dibayar";
      })
      ->editColumn('status_shipping', function($data){ 
        if($data->status_shipping == 0) return "Sedang diproses";
        else if($data->status_shipping == 1) return "Sudah dikirim";
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
?>
