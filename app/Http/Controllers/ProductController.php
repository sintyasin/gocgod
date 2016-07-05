<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Session;
use Cart;
use Auth;
use App\Http\Requests;
use App\Product;
use App\ProductCategory;
use App\NameProduct;
use App\ProductTestimonial;
use App\Member;
use App\TransactionController;
use App\SampleDetail;
use App\SampleRequest;
use App\AboutUs;

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

    public function getMenu()
    {
        $data['contact'] = AboutUs::first();
    	$data['query'] = Product::paginate(12);
        $i = 0;
        //masukkin data kategori ke array
        foreach($data['query'] as $tmp)
        {
            $data['queryCategory'][$i] = ProductCategory::find($tmp->category_id);
            $i++;
        }
        
    	return view('page.menu', $data);
    }

    public function getMenuDetail($id)
    {
        $data['contact'] = AboutUs::first();
        $data['query_testimonial'] = ProductTestimonial::where('varian_id', $id)
                                                        ->where('approval', 1)
                                                        ->get();
    	$data['query'] = Product::where('varian_id', $id)->first();
        $data['queryCategory'] = ProductCategory::find($data['query']->category_id);
        $i = 0;
        foreach($data['query_testimonial'] as $tmp)
        {
            $data['query_member'][$i] = Member::find($tmp->id);
            $i++;
        }

        return view('page.menu_detail', $data);
    }

    public function getMenuSample()
    {
        $data['contact'] = AboutUs::first();
        $data['query'] = Product::all();
        
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

    public function productSample($id)
    {
        $data['contact'] = AboutUs::first();
        $data['request_data'] = SampleRequest::where('request_id', $id)->first();
        //dd($data['request_data']);
        $data['query'] = Product::all();

        return view('page.productsample_1', $data);
    }

    public function productsampledata(Request $request)
    {
        $a = Validator::make($request->all(),[
            'id' => 'required|numeric',
            ]);

        $input = $request->all();

        for($i=0; $i<5; $i++)
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
                    /*$update = SampleDetail::where('request_id', $request_id)
                        ->where('varian_id', $varian_id)
                        ->first();*/
                    $total = $check->quantity + intval($quantity);

                    /*var_dump($total);
                    $check->quantity = $total;
                    $check->save();*/
                    // $update = 
                    \DB::table('transaction__sample_detail')
                        ->where('request_id', $request_id)
                        ->where('varian_id', $varian_id)
                        ->increment('quantity', $quantity);
                        //->update(['quantity'=>('quantity'+$quantity)]);
                }
                else
                {
                    $sample = new SampleDetail;
                    $sample->request_id = $request_id;
                    $sample->varian_id = $varian_id;
                    $sample->quantity = $quantity;
                    $sample->save();
                }
                // else
                // {
                //     $sample = new SampleDetail;
                //     $sample->request_id = $request_id;
                //     $sample->varian_id = $varian_id;
                //     $sample->quantity = $quantity;
                //     $sample->save();
                // }
            }
        }
        return redirect('/home');
    }

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

        $event = new SampleRequest;
        $event->agent_id = $id;
        $event->event_name = $event_name;
        $event->event_date = $event_date;
        $event->event_venue = $event_venue;
        $event->event_description = $event_description;
        $event->request_date = $request_date;
        $event->save();

        return redirect('/productsample/'.$event->request_id);
    }

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

    public function getAllMenu()
    {
        $data['contact'] = AboutUs::first();
        //$data['query_menu'] = Product::all();
        $data['query_menu'] = Product::leftJoin('product__category as c', 'c.category_id', '=', 'product__varian.category_id')
                                     ->get(['varian_name', 'varian_id', 'price', 'picture', 'product__varian.description as description', 'category_name']);
//dd($data['query_menu']);
        $i = 0;
        //masukkin data kategori ke array
        /*foreach($data['query_menu'] as $tmp)
        {
            $data['queryCategory'][$i] = ProductCategory::find($tmp->category_id);
            $i++;
        }*/

        // //musti dijoin 3 table
        // foreach($data['cart_content'] as $temp)
        // {
        //     $data['query_content'][$j] = ProductCategory::find($temp->);
        // }
         
        // dd($data['cart_content']);

        return view('page.checkout_subcriber', $data);
    }


}
