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
        $rowid = Cart::search(array('id' => $data->id));

        if($rowid){
            $item = Cart::get($rowid[0]);
            dd($data->qty);

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
    }

}
