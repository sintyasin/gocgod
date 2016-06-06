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

class TransactionController extends Controller
{
    
    public function addcart(Request $data)
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

        Cart::add([
            'id'=> $data->id, 
            'qty' => $data->qty,
            'name' => $data->name,
            'price' => $data->price,
            ]);

        //$rowId = Cart::search(array('id' => $data->id));

        $total = Cart::total();

        $response = array(
            'id' => $data->id,
            'qty' => $data->qty,
            'name' => $data->name,
            'price' => $data->price,
            'total' => $total
            //'rowId' => $rowId
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
