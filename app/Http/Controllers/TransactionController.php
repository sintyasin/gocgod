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
    // public function getMenu()
    // {
    // 	$data['query'] = Product::all();
    //     $i = 0;
    //     //masukkin data kategori ke array
    //     foreach($data['query'] as $tmp)
    //     {
    //         $data['queryCategory'][$i] = ProductCategory::find($tmp->category_id);
    //         $i++;
    //     }
        
    // 	return view('page.menu', $data);
    // }

    // public function getMenuDetail($id)
    // {
    //     $data['query_testimonial'] = ProductTestimonial::where('varian_id', $id)
    //                                                     ->where('approval', 1)
    //                                                     ->get();
    // 	$data['query'] = Product::where('varian_id', $id)->first();
    //     $data['queryCategory'] = ProductCategory::find($data['query']->category_id);
    //     $i = 0;
    //     foreach($data['query_testimonial'] as $tmp)
    //     {
    //         $data['query_member'][$i] = Member::find($tmp->id);
    //         $i++;
    //     }

    //     return view('page.menu_detail', $data);
    // }

    // public function getMenuSample()
    // {
    //     $data['query'] = Product::all();
        
    //     return view('page.productsample', $data);
    // }
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

    // public function updatecart(Request $data)
    // {
    //     dd($data->rowId, $data->qty);
    //     $v = Validator::make($data->all(),[
    //         'qty' =>'required|numeric',
    //         ]);
    //     if($v->fails())
    //     {
    //         return "Not completed data";
    //     }

    //     Cart::update($data->rowId, ['qty' => $data->qty]);
    // }

    public function updateCart()
    {
        if (Request::wantsJson()) {
            $validator = Validator::make(Input::only('kode', 'rowId', 'qty'),
                array(
                    'kode'  => 'required|numeric',
                    'rowId' => 'required',
                    'qty'   => 'required|integer|min:1')
                );

            if ($validator->fails()) {
                $error = array(
                    'type'    => 'validation_fail',
                    'code'    => 'ERR-CART-401',
                    'message' => $validator->messages());

                return Response::json(compact('error'));
            } else {
                $row_id       = Input::get('rowId');
                $product_qty  = Input::get('qty');
                $product_code = Input::get('kode');

                if ($product_qty > 0) {
                    //validasi qty stock!!!
                    $detail = DB::table('product__varian')->where('varian__id', $product_code)->first();

                    if ($product_qty > $detail->stock) {
                        $error = array(
                            'type'    => 'invalid_stock',
                            'code'    => 'ERR-CART-402',
                            'message' => ['warning' => trans('shop.invalid-stock')]);

                        return Response::json(compact('error'));
                    } else {
                        //if price don't have discount!!!
                        

                        Cart::update($row_id, $product_qty);

                        $success = array(
                            'type'    => 'success_update_cart',
                            'code'    => 'OK-CART-200',
                            'data' => [
                                'subtotal' => Localization::money(Cart::get($row_id)->subtotal),
                                'total'    => Localization::money(Cart::total()),
                                'count'    => Cart::count()
                                ]);

                        return Response::json(compact('success'));
                    }
                } else {
                    $error = array(
                        'type'    => 'invalid_stock',
                        'code'    => 'ERR-TOPUP-402',
                        'message' => ['warning' => trans('shop.invalid-stock')]
                        );

                    return Response::json(compact('error'));
                }
            }
        } else {
            return 'Invalid Request';
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
    // public function updateCart()
    // {
    //     if (Request::wantsJson()) {
    //         $v = Validator::make($data->all(),[
    //             'qty' =>'required|numeric',
    //         ]);
    //         if($v->fails())
    //         {
    //             return "Not completed data";
    //         }

    //             return Response::json(compact('error'));
    //         } else {
    //             $row_id       = Input::get('rowId');
    //             $product_qty  = Input::get('qty');
    //             $product_code = Input::get('kode');

    //             if ($product_qty > 0) {
    //                 //validasi qty stock!!!
    //                 $detail = DB::table('product__varian')->where('varian_id', $product_code)->first();

    //                 if ($product_qty > $detail->stock) {
    //                     $error = array(
    //                         'type'    => 'invalid_stock',
    //                         'code'    => 'ERR-CART-402',
    //                         'message' => ['warning' => trans('shop.invalid-stock')]);

    //                     return Response::json(compact('error'));
    //                 } else {
    //                     //if price don't have discount!!!
    //                     $product_price = 0;
    //                     $product_price = $detail->discounted_price;

    //                     if ($product_price == 0 || is_null($product_price)) {
    //                         $product_price = $detail->normal_price;
    //                     }

    //                     Cart::update($row_id, ['qty'=> $product_qty]);

    //                     $success = array(
    //                         'type'    => 'success_update_cart',
    //                         'code'    => 'OK-CART-200',
    //                         'data' => [
    //                             'subtotal' => Localization::money(Cart::get($row_id)->subtotal),
    //                             'total'    => Localization::money(Cart::total()),
    //                             'count'    => Cart::count()
    //                             ]);

    //                     return Response::json(compact('success'));
    //                 }
    //             } else {
    //                 $error = array(
    //                     'type'    => 'invalid_stock',
    //                     'code'    => 'ERR-TOPUP-402',
    //                     'message' => ['warning' => trans('shop.invalid-stock')]
    //                     );

    //                 return Response::json(compact('error'));
    //             }
    //         }
    //     } else {
    //         return 'Invalid Request';
    //     }
    // }
    // public function transactionAll(Request $data_transaction)
    // {
    //     $v = Validator::make($data_transaction->all(), [
    //         'buyer' => 'required|max:15',
            
    //         ]);


    // }

    // public function giveTestimonial(Request $data_testimonial, $idd)
    // {
    //     $v = Validator::make($data_testimonial->all(),[
    //         'testimonial'   => 'required|max:500',
    //         ]);

    //     if ($v->fails())
    //     {
    //         return redirect('/menu_detail/'.$idd)->withErrors($v->errors())->withInput();
    //     }    

    //     $input = $data_testimonial->all();

    //     $id = Auth::user()->id;
    //     $varian_id = $idd;
    //     $testimonial = filter_var($input['testimonial'], FILTER_SANITIZE_STRING);

    //     $testi = new ProductTestimonial;
    //     $testi->id = $id;
    //     $testi->varian_id = $varian_id;
    //     $testi->testimonial = $testimonial;
    //     $testi->save();

    //     return redirect('/menu_detail/'.$idd);
    // }

    // public function getAllMenu()
    // {
    //     $data['query_menu'] = Product::all();
    //     $i = 0;
    //     //masukkin data kategori ke array
    //     foreach($data['query_menu'] as $tmp)
    //     {
    //         $data['queryCategory'][$i] = ProductCategory::find($tmp->category_id);
    //         $i++;
    //     }

    //     return view('page.checkout', $data);
    // }
}
