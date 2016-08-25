<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use Validator;
use Session;
use Cart;
use Auth;
use App\Http\Requests;
use App\Product;
use App\ProductCategory;
use App\ProductTestimonial;
use App\Member;
use App\TransactionController;
use App\SampleDetail;
use App\SampleRequest;
use App\AboutUs;
use App\CutOffDate;

class ProductController extends Controller
{

    public function howToBuy()
    {
        $data['contact'] = AboutUs::first();
        return view('page.howtobuy', $data);
    }

    public function howToBuyFirst()
    {
        return view('page.howtobuyfirst');
    }

    public function howToBuySingle()
    {
        return view('page.howtobuysingle');
    }

    public function howToBuySubcriber()
    {
        return view('page.howtobuysubcriber');
    }

    //---------------- MENU -----------------
    public function getMenu(Request $request)
    {
        $data['contact'] = AboutUs::first();
    	$data['query'] = Product::leftJoin('product__category as pc', 'product__varian.category_id', '=', 'pc.category_id')
                        ->paginate(12);
        
        if($request->wantsJson())
        {
            $success = array(
                'type' => 'OK-MENU',
                'message' => 'success',
                'data' => array(
                    'productPagination' => $data['query']));
            return Response::json(compact('success'));
        }
        
    	return view('page.menu', $data);
    }

    //---------------- MENU DETAIL -----------------
    public function getMenuDetail($id, Request $request)
    {
        $data['contact'] = AboutUs::first();

    	$data['query'] = Product::leftJoin('product__category as pc', 'product__varian.category_id', '=', 'pc.category_id')
                                ->where('varian_id', $id)
                                ->select('product__varian.description as description', 'picture', 'varian_name', 'price', 'qty' , 'weight', 'category_name', 'product__varian.varian_id as varian_id')
                                ->first();

        if($request->wantsJson())
        {
            $success = array(
                'type' => 'OK-MENU DETAIL',
                'message' => 'success',
                'data' => array(
                    'productData' => $data['query']
                    ));
            return Response::json(compact('success'));
        }

        return view('page.menu_detail', $data);
    }

    //---------------- MENU DETAIL - Testimonial Data -------------    
    public function testimonial(Request $request, $id)
    {
        $data = ProductTestimonial::leftJoin('master__member as mm', 'product__testimonial.id', '=', 'mm.id')
                                                        ->select('name', 'product__testimonial.created_at', 'testimonial')
                                                        ->where('varian_id', $id)
                                                        ->where('approval', 1)
                                                        ->orderBy('testimonial_id', 'desc')
                                                        ->paginate(5);
        
        if($request->wantsJson())
        {
            $success = array(
                'type' => 'OK-PRODUCT TEESTIMONIAL',
                'message' => 'success',
                'data' => array(
                    'productTestimonial' => $data
                    ));
            return Response::json(compact('success'));
        }

        return view('page.testimonial', compact('data'));
    }

    //---------------- MENU DETAIL - Ambil testimonial -----------------
    public function giveTestimonial(Request $data_testimonial, $idd)
    {
        $v = Validator::make($data_testimonial->all(),[
            'testimonial'   => 'required|max:500',
            ]);

        if ($v->fails())
        {
            return redirect('/menu_detail/'.$idd)->withErrors($v->errors())->withInput();
        }    

        $input = $data_testimonial->all();

        $id = Auth::user()->id;
        $varian_id = $idd;
        $testimonial = filter_var($input['testimonial'], FILTER_SANITIZE_STRING);

        $testi = new ProductTestimonial;
        $testi->id = $id;
        $testi->varian_id = $varian_id;
        $testi->testimonial = $testimonial;
        $testi->save();

        Session::flash('status', 'Terima kasih atas review Anda. Review Anda akan kami proses.');
        return redirect('/menu_detail/'.$idd);
    }

    //---------------- SAMPLE PRODUCT - Page isi data event -----------------
    public function getMenuSample()
    {
        $data['contact'] = AboutUs::first();
        
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
        return view('page.productsample', $data);
    }

    //---------------- SAMPLE PRODUCT - Ambil data event -----------------
    public function eventsample(Request $request)
    {
        $v = Validator::make($request->all(),[
            'event_name' => 'required|max:100',
            'event_date' => 'required|max:10',
            'event_venue' => 'required|max:100',
            'event_description' => 'required|max:1000',
            'request_date' => 'required|max:10',
            ]);

        if ($v->fails())
        {
            return redirect('productsample')->withErrors($v->errors())->withInput();
        }

        $input = $request->all();

        $id = Auth::user()->id;
        $event_name = filter_var($input['event_name'], FILTER_SANITIZE_STRING);
        $event_date = filter_var($input['event_date'], FILTER_SANITIZE_STRING);
        $event_venue = filter_var($input['event_venue'], FILTER_SANITIZE_STRING);
        $event_description = filter_var($input['event_description'], FILTER_SANITIZE_STRING);
        $request_date = filter_var($input['request_date'], FILTER_SANITIZE_STRING);

        date_default_timezone_set('Asia/Jakarta');
        $date_order = new  \DateTime();
        $order_date = date_format($date_order, "Y-m-d H:i:s");

        $event = new SampleRequest;
        $event->agent_id = $id;
        $event->event_name = $event_name;
        $event->event_date = $event_date;
        $event->event_venue = $event_venue;
        $event->event_description = $event_description;
        $event->shipping_date = $request_date;
        $event->request_date = $order_date;
        $event->save();

        return redirect('/productsample/'.$event->request_id);
    }

    //---------------- SAMPLE PRODUCT - Page isi data product yang diinginkan -----------------
    public function productSample($id, Request $request)
    {
        $data['contact'] = AboutUs::first();
        $data['request_data'] = SampleRequest::where('request_id', $id)->first();
        $data['query'] = Product::all();

        if($request->wantsJson())
        {
            $success = array(
                'type' => 'OK-SAMPLE PRODUCT - page isi data product',
                'data' => array($data['request_data'], $data['query']));
            return Response::json(compact('success'));
        }

        return view('page.productsample_1', $data);
    }

    //---------------- SAMPLE PRODUCT - Ambil data product yang diinginkan -----------------
    public function productsampledata(Request $request)
    {
        $a = Validator::make($request->all(),[
            'id' => 'required|numeric',
            ]);

        $input = $request->all();

        for($i=0; $i<100; $i++)
        {
            $v = Validator::make($request->all(),[
                $i.'-product' => 'required|numeric',
            ]);

            if ($v->fails())
            {
                continue;
            }
            else{
                $request_id = filter_var($input['id'], FILTER_SANITIZE_STRING);
                $varian_id = filter_var($input[$i.'-product'], FILTER_SANITIZE_STRING);
                $quantity = filter_var($input[$i.'-qty'], FILTER_SANITIZE_STRING);

                $check = SampleDetail::where('request_id', $request_id)->where('varian_id', $varian_id)->first();
                if(count($check))
                {   
                    $total = $check->quantity + intval($quantity);
                    \DB::table('transaction__sample_detail')
                        ->where('request_id', $request_id)
                        ->where('varian_id', $varian_id)
                        ->increment('quantity', $quantity);
                }
                else
                {
                    $sample = new SampleDetail;
                    $sample->request_id = $request_id;
                    $sample->varian_id = $varian_id;
                    $sample->quantity = $quantity;
                    $sample->save();
                }
            }
        }
        Session::flash('success_product_sample', 'Permintaan Anda akan segera di proses, pihak GoCGoD akan menghubungi Anda!');
        return redirect('/home');
    }

    //---------------- SUBSCRIBER - Page semua produk di tampilkan -----------------
    public function getAllMenu(Request $request)
    {
        $data['contact'] = AboutUs::first();
        $data['query_menu'] = Product::leftJoin('product__category as c', 'c.category_id', '=', 'product__varian.category_id')
                                     ->get(['varian_name', 'varian_id', 'price', 'picture', 'product__varian.description as description', 'category_name']);
        
        if($request->wantsJson())
        {
            $success = array(
                'type' => 'OK-SUBCRIBER - page semua produk',
                'data' => $data['query_menu']);
            return Response::json(compact('success'));
        }
        return view('page.checkout_subcriber', $data);
    }
}
?>
