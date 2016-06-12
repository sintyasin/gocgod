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

class ProductDataOrder
{
  public $name;
  public $quantity;
  public $price;
}

class TransactionController extends Controller
{
    
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
                            ->get(['order_id', 'c.name as customer', 'order_date', 'ship_address', 'c.phone as phone','city_name', 'status_confirmed', 'status_shipping' ,'who']);
        


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

  public function order_details()
  {
     $data['query_menu'] = Product::all();
        $i = 0;
        //masukkin data kategori ke array
        foreach($data['query_menu'] as $tmp)
        {
            $data['queryCategory'][$i] = ProductCategory::find($tmp->category_id);
            $i++;
        }

        // //musti dijoin 3 table
        // foreach($data['cart_content'] as $temp)
        // {
        //     $data['query_content'][$j] = ProductCategory::find($temp->);
        // }
         
        // dd($data['cart_content']);

        return view('page.checkout_subcriber_2', $data);
  }

}
