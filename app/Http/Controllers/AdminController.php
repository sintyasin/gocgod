<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
//use App\Http\Requests;
//use Request;
use Validator;
use Session;
use Auth;
use Excel;
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
use App\Req_agent;
use App\Bank;
use App\Member;
use App\Banner;
use App\Balance;
use App\TxOrderConfirmation;

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

class PO
{
  public $name;
  public $id;
  public $varian;
  public $quantity;
  public $price;
}

class AdminController extends Controller
{
  public function getConfirmTx()
  {
    date_default_timezone_set('Asia/Jakarta');
    $today = new \DateTime(NULL);
    date_add($today,date_interval_create_from_date_string("-8 days"));
    $date = date_format($today,"Y-m-d");

    DB::transaction(function() use ($date)
    {
      //AMBIL ORDER ID DARI DATA YG MAU DI UPDATE
      $query = TxOrder::where('status_confirmed', 0)
                      ->where('status_shipping', 1)
                      ->where('status_payment', 1)
                      ->where('shipping_date', '<=', $date)
                      ->get(['order_id', 'agent_id', 'total', 'group_id']);

      //UPDATE KONFIRMASI USER
      DB::update('UPDATE transaction__order
                  SET status_confirmed = 1 
                  WHERE status_confirmed = 0 
                  AND status_shipping = 1 
                  AND status_payment = 1 
                  AND shipping_date <= ?', [$date]);

      //INSERT DATA KE TX BALANCE DAN AGENT
      foreach ($query as $data) {
        $count = TxOrder::where('group_id', $data->group_id)->count();
        $total = ($data->total / $count) * 0.1;

        $balance = new Balance;
        $balance->agent_id = $data->agent_id;
        $balance->amountMoney = $total;
        $balance->balance_type = 1;
        $balance->order_id = $data->order_id;
        $balance->statusTransfer = 0;
        $balance->save();

        $agent = Member::find($data->agent_id);
        $agent->balance = $agent->balance + $total;
        $agent->save();
      }
    });
  }

  //DEPOSTI WITHDRAWAL
  public function getDeposit()
  {
    $data['active'] = 'deposit';

    return view('admin.admin_deposit', $data);
  }

  public function getDepositAll()
  {
    return view('admin.admin_deposit_all');
  }

  public function getDepositData()
  {
    $data['query'] = Balance::leftJoin('master__member as m', 'm.id', '=', 'agent_id')
                            ->get(['balance_id', 'm.name as name', 'amountMoney', 'balance_type', 'order_id', 'statusTransfer']);
    
    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getDepositFinish()
  {
    return view('admin.admin_deposit_finish');
  }

  public function getDepositFinishData()
  {
    $data['query'] = Balance::leftJoin('master__member as m', 'm.id', '=', 'agent_id')
                            ->where('statusTransfer', 1)
                            ->where('balance_type', 0)
                            ->get(['balance_id', 'm.name as name', 'amountMoney', 'balance_type', 'order_id', 'statusTransfer']);
    
    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getDepositUnfinish()
  {
    return view('admin.admin_deposit_unfinish');
  }

  public function getDepositUnfinishData()
  {
    $data['query'] = Balance::leftJoin('master__member as m', 'm.id', '=', 'agent_id')
                            ->where('statusTransfer', 0)
                            ->where('balance_type', 0)
                            ->whereNull('order_id')
                            ->get(['balance_id', 'm.name as name', 'amountMoney', 'balance_type', 'statusTransfer']);
    
    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getProcessBalance(Request $request)
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
         
    $deposit = Balance::find($id);
    $deposit->statusTransfer = 1;
    $deposit->balance_type = 0;
    $deposit->save();

    return 1;
  }

  //BANNER
  public function getBannerList()
  {
    $data['active'] = 'bannerList';

    return view('admin.admin_banner', $data);
  }

  public function getBannerData()
  {
    $data['query'] = Banner::get(['id', 'name', 'alias', 'description1', 'description2', 'price', 'picture']);
    
    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getInsertBanner()
  {
    $data['active'] = "insertBanner";

    return view('admin.admin_insert_banner', $data);
  }

  public function postInsertBanner(Request $request)
  {
    $input = $request->all();

    $v = Validator::make($request->all(), [
        'name' => 'required|max:50',
        'alias' => 'max:50',
        'desc1' => 'max:50',
        'desc2' => 'max:50',
        'price' => 'numeric',
        'picture' => 'mimes:png',
    ]);

    if ($v->fails())
    {
        return redirect('/admin/insert/banner')->withErrors($v->errors())->withInput();
    }    

    $name = filter_var($input['name'], FILTER_SANITIZE_STRING);
    $alias = filter_var($input['alias'], FILTER_SANITIZE_STRING);
    $desc1 = filter_var($input['desc1'], FILTER_SANITIZE_STRING);
    $desc2 = filter_var($input['desc2'], FILTER_SANITIZE_STRING);
    $price = filter_var($input['price'], FILTER_SANITIZE_STRING);
    $picture = $input['picture'];
    list($width, $height) = getimagesize($picture);
    
    if($picture->getClientSize() > 512000)
    {
      return redirect('/admin/insert/banner')->with('errorSize', 'The picture size cannot be larger than 500 kilobytes')->withInput();
    }
    else if($width > 633 || $height > 761)
    {
      return redirect('/admin/insert/banner')->with('errorSize', 'The picture dimension cannot be larger than 633x761')->withInput();
    }


    $fileName = filter_var($picture->getClientOriginalName(), FILTER_SANITIZE_STRING);
    $fileName = preg_replace('~[\\\\/:*?"<>|-]~', '', $fileName);
    $fileName = str_replace(' ', '_', $fileName);
    $fileName = time() . $fileName;

    $banner = new Banner;
    $banner->name = $name;
    $banner->alias = $alias;
    $banner->description1 = $desc1;
    $banner->description2 = $desc2;
    $banner->price = $price;
    $banner->picture = $fileName;
    $banner->save();

    //pindahin gambarnya
    $picture->move(base_path() . '/public/assets/images/slider/' , $fileName);

    Session::flash('insert', 1);
    return redirect('admin/insert/banner/');
  }

  public function getEditBanner($id)
  {
    $data['query'] = Banner::find($id);
    $data['active'] = "bannerList";

    return view('admin.admin_edit_banner', $data);
  }

  public function postEditBanner(Request $request, $id)
  {
    $input = $request->all();

    //kalo dia insert new category
    $v = Validator::make($request->all(), [
        'name' => 'required|max:50',
        'alias' => 'max:50',
        'desc1' => 'max:50',
        'desc2' => 'max:50',
        'price' => 'numeric',
        'picture' => 'mimes:png',
    ]);    

    if ($v->fails())
    {
        return redirect('/admin/edit/banner/' . $id)->withErrors($v->errors())->withInput();
    }    

    $name = filter_var($input['name'], FILTER_SANITIZE_STRING);
    $alias = filter_var($input['alias'], FILTER_SANITIZE_STRING);
    $desc1 = filter_var($input['desc1'], FILTER_SANITIZE_STRING);
    $desc2 = filter_var($input['desc2'], FILTER_SANITIZE_STRING);
    $price = filter_var($input['price'], FILTER_SANITIZE_STRING);
    $picture = $input['picture'];
    list($width, $height) = getimagesize($picture);
    
    
    //kalo upload file baru
    if($_FILES["picture"]["error"] != 4) 
    {
      $picture = $input['picture'];

      if($picture->getClientSize() > 512000)
      {
        return redirect('/admin/insert/banner')->with('errorSize', 'The picture size cannot be larger than 500 kilobytes')->withInput();
      }
      else if($width > 633 || $height > 761)
      {
        return redirect('/admin/insert/banner')->with('errorSize', 'The picture dimension cannot be larger than 633x761')->withInput();
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

    $banner = Banner::find($id);
    //ambil data picture lama, untuk di delete gambarnya
    $oldPicture = $banner->picture;

    $banner->name = $name;
    $banner->alias = $alias;
    $banner->description1 = $desc1;
    $banner->description2 = $desc2;
    $banner->price = $price;
    if($picture != null)
      $banner->picture = $fileName;
    $banner->save();

    if($picture != null)
    {
      //pindahin gambarnya
      $picture->move(base_path() . '/public/assets/images/slider/' . '/', $fileName);
    
      $path = base_path() . "/public/assets/images/slider/" . $oldPicture;
      $fileExist = file_exists($path);
      if($fileExist)
      {
        unlink($path);
      }
    }

    Session::flash('update', 1); 
    return redirect('/admin/banner/list');
  }

  public function deleteBanner(Request $request)
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
         
    Banner::find($id)->delete();
    Session::flash('delete', 1);

    return 1;
  }

  //BANK
  public function getBankList()
  {
    $data['active'] = 'bankList';

    return view('admin.admin_bank_list', $data);
  }

  public function getBankData()
  {
    $data['query'] = Bank::get(['bank_id', 'bank_name']);
        
    return Datatables::of($data['query'])
    ->make(true);
  }

  public function insertBank()
  {
    $data['active'] = "insertBank";

    return view('admin.admin_insert_bank', $data);
  }

  public function postInsertBank(Request $request)
  {
    $v = Validator::make($request->all(), [
        'bank'       => 'required|max:20',
    ]);

    if ($v->fails())
    {
        return redirect('/admin/insert/bank')->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $inputBank = filter_var($input['bank'], FILTER_SANITIZE_STRING);

    $bank = new Bank();
    $bank->bank_name = $inputBank;
    $bank->save();
    Session::flash('success', 1);
    return redirect('/admin/insert/bank');
  }

  public function getEditBank($id)
  {
    $data['query'] = Bank::find($id);
    $data['active'] = 'bankList';

    return view('admin.admin_edit_bank', $data);
  }

  public function postEditBank(Request $request, $id)
  {
    $v = Validator::make($request->all(), [
        'bank'       => 'required|max:250',
    ]);

    if ($v->fails())
    {
        return redirect('/admin/edit/bank/' . $id)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $inputBank = filter_var($input['bank'], FILTER_SANITIZE_STRING);

    $bank = Bank::find($id);
    $bank->bank_name = $inputBank;
    $bank->save();
    Session::flash('update', 1);

    return redirect('/admin/bank/list');
  }

  public function deleteBank(Request $request)
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
         
    Bank::find($id)->delete();
    Session::flash('delete', 1);

    return 1;
  }

  //PURCHASE ORDER
  public function getPurchaseList(Request $request)
  {
    date_default_timezone_set('Asia/Jakarta');
    $input = $request->all();

    $start = filter_var($input['dateStart'], FILTER_SANITIZE_STRING);
    $end = filter_var($input['dateEnd'], FILTER_SANITIZE_STRING);
    $export = filter_var($input['export'], FILTER_SANITIZE_STRING);
    
    $monday; $sunday;
    if($start == "" || $end == "")
    {
      $monday = date("Y-m-d", strtotime( "next monday"));
      $sunday = date("Y-m-d", strtotime( "next monday +6 day"));
    }
    else
    {
      $monday = $start;
      $sunday = $end;
    }
    
    $data['start'] = $monday;
    $data['end'] = $sunday;

    $data['active'] = 'purchase';

    $query = DB::table('transaction__order')
            ->select('m.name as Agent', 'p.varian_name as Product', DB::raw('SUM(d.quantity) as Quantity'), DB::raw('(d.varian_price * SUM(d.quantity)) as Total'))
            ->leftJoin('transaction__order_detail as d', 'd.order_id', '=', 'transaction__order.order_id')
            ->leftJoin('product__varian as p', 'p.varian_id', '=', 'd.varian_id')
            ->leftJoin('master__member as m', 'm.id', '=', 'transaction__order.agent_id')
            ->where('shipping_date', '>=', $monday)
            ->where('shipping_date', '<=', $sunday)
            ->where('status_payment', '=', 1)
            ->groupBy('Agent', 'Product')
            ->get();

    if(!empty($query))
    {
      $data['query'] = $query;
      
      $queryProduct = DB::table('transaction__order')
              ->select('p.varian_name as Product', DB::raw('SUM(d.quantity) as Quantity'), DB::raw('SUM(d.varian_price * d.quantity) as Total'))
              ->leftJoin('transaction__order_detail as d', 'd.order_id', '=', 'transaction__order.order_id')
              ->leftJoin('product__varian as p', 'p.varian_id', '=', 'd.varian_id')
              ->where('shipping_date', '>=', $monday)
              ->where('shipping_date', '<=', $sunday)
              ->where('status_payment', '=', 1)
              ->groupBy('Product')
              ->get();

      if(!empty($queryProduct))
      {
        $data['product'] = $queryProduct;
      }
      else
      {
        $data['product'] = 0;
      }


      if($export == 1)
      {
        $arrayAgent = json_decode(json_encode($query), true);        
        $arrayProduct = json_decode(json_encode($queryProduct), true);

        $filename = "Purchase Order " . $monday . " - " . $sunday;

        return Excel::create($filename, function($excel) use ($arrayAgent, $arrayProduct) {
          $excel->sheet('PO per agent', function($sheet) use ($arrayAgent)
          {
            $sheet->fromArray($arrayAgent);
          });

          $excel->sheet('PO per Product', function($sheet) use ($arrayProduct)
          {
            $sheet->fromArray($arrayProduct);
          });
        })->download('xlsx');
      }
    }
    else
    {
      $data['query'] = 0;
      $data['product'] = 0;
    }

    return view('admin.admin_purchase_list', $data);
  }

  //REPORT
  public function getProductReport(Request $request)
  {
    date_default_timezone_set('Asia/Jakarta');
    $input = $request->all();

    $start = filter_var($input['dateStart'], FILTER_SANITIZE_STRING);
    $end = filter_var($input['dateEnd'], FILTER_SANITIZE_STRING);
    
    $first; $last;
    if($start == "" || $end == "")
    {
      $first = date("Y-m-d", strtotime( "first day of this month"));
      $last = date("Y-m-d", strtotime( "last day of this month"));
    }
    else
    {
      $first = $start;
      $last = $end;
    }
    
    $data['start'] = $first;
    $data['end'] = $last;

    $data['active'] = 'productReport';

    $query = DB::table('transaction__order')
            ->select('p.varian_name as name', DB::raw('SUM(d.quantity) as quantity'), DB::raw('SUM(d.varian_price * d.quantity) as price'))
            ->leftJoin('transaction__order_detail as d', 'd.order_id', '=', 'transaction__order.order_id')
            ->leftJoin('product__varian as p', 'p.varian_id', '=', 'd.varian_id')
            ->where('order_date', '>=', $first)
            ->where('order_date', '<=', $last)
            ->where('status_payment', '=', 1)
            ->groupBy(DB::raw('name WITH ROLLUP'))
            ->get();

    if(!empty($query))
    {
      $data['product'] = $query;
    }
    else
    {
      $data['product'] = 0;
    }
    
    return view('admin.admin_report_product', $data);
  }

  public function getTxReport(Request $request)
  {
    date_default_timezone_set('Asia/Jakarta');
    $input = $request->all();

    $start = filter_var($input['dateStart'], FILTER_SANITIZE_STRING);
    $end = filter_var($input['dateEnd'], FILTER_SANITIZE_STRING);
    
    $first; $last;
    if($start == "" || $end == "")
    {
      $first = date("Y-m-d", strtotime( "first day of this month"));
      $last = date("Y-m-d", strtotime( "last day of this month"));
    }
    else
    {
      $first = $start;
      $last = $end;
    }
    
    $data['start'] = $first;
    $data['end'] = $last;

    $data['active'] = 'txReport';

    $shippingQuery = DB::table('transaction__order')
              ->select('shipping_fee', 'group_id')
              ->where('order_date', '>=', $first)
              ->where('order_date', '<=', $last)
              ->where('status_payment', '=', 1)
              ->get();

    $shipping = 0;
    $groupId = -1;
    foreach ($shippingQuery as $value) {
      if($groupId == -1)
      {
        $shipping += $value->shipping_fee;
        $groupId = $value->group_id;  
      }
      else if($value->group_id == $groupId) continue;
      else
      {
        $shipping += $value->shipping_fee;
        $groupId = $value->group_id;  
      }
    }
    
    $query = DB::table('transaction__order')
            ->select(DB::raw('DATE(order_date) as Date') , DB::raw('COUNT(DISTINCT transaction__order.order_id) as Total_Order'), DB::raw('SUM(d.quantity) as Quantity'), DB::raw('(SUM(d.varian_price * d.quantity) + ' . $shipping . ') as Omzet'), DB::raw($shipping . ' as Shipping'), DB::raw('SUM(d.varian_price * d.quantity) as Net'))
            ->leftJoin('transaction__order_detail as d', 'd.order_id', '=', 'transaction__order.order_id')
            ->leftJoin('product__varian as p', 'p.varian_id', '=', 'd.varian_id')
            ->leftJoin('master__member as m', 'm.id', '=', 'transaction__order.agent_id')
            ->where('order_date', '>=', $first)
            ->where('order_date', '<=', $last)
            ->where('status_payment', '=', 1)
            ->groupBy('Date')
            ->orderBy('Date')
            ->get();

    $order = 0; $qty = 0; $omzet = 0; $shipping = 0; $net = 0;
    if(!empty($query))
    {
      $array = json_decode(json_encode($query), true);
      foreach ($array as $tmp) {
        $order += $tmp['Total_Order'];
        $qty += $tmp['Quantity'];
        $omzet += $tmp['Omzet'];
        $shipping += $tmp['Shipping'];
        $net += $tmp['Net'];
      }

      $insert = array('Date' => 'TOTAL', 'Total_Order' => $order, 'Quantity' => $qty, 'Omzet' => $omzet, 'Shipping' => $shipping, 'Net' => $net);
      array_push($array, $insert);

      $data['query'] = $array;
    }
    else
    {
      $data['query'] = 0; 
    }
    
    return view('admin.admin_report_tx', $data);
  }
  
  public function getAgentReport(Request $request)
  {
    date_default_timezone_set('Asia/Jakarta');
    $input = $request->all();

    $start = filter_var($input['dateStart'], FILTER_SANITIZE_STRING);
    $end = filter_var($input['dateEnd'], FILTER_SANITIZE_STRING);
    
    $first; $last;
    if($start == "" || $end == "")
    {
      $first = date("Y-m-d", strtotime( "first day of this month"));
      $last = date("Y-m-d", strtotime( "last day of this month"));
    }
    else
    {
      $first = $start;
      $last = $end;
    }
    
    $data['start'] = $first;
    $data['end'] = $last;

    $data['active'] = 'agentReport';

    $shippingQuery = DB::table('transaction__order')
              ->select('shipping_fee', 'group_id')
              ->where('order_date', '>=', $first)
              ->where('order_date', '<=', $last)
              ->where('status_payment', '=', 1)
              ->get();

    $shipping = 0;
    $groupId = -1;
    foreach ($shippingQuery as $value) {
      if($groupId == -1)
      {
        $shipping += $value->shipping_fee;
        $groupId = $value->group_id;  
      }
      else if($value->group_id == $groupId) continue;
      else
      {
        $shipping += $value->shipping_fee;
        $groupId = $value->group_id;  
      }
    }

    $query = DB::table('transaction__order')
            ->select('m.name as Agent', DB::raw('COUNT(DISTINCT transaction__order.order_id) as Total_Order'), DB::raw('SUM(d.quantity) as Quantity'), DB::raw('(SUM(d.varian_price * d.quantity) + ' . $shipping . ') as Omzet'), DB::raw($shipping . ' as Shipping'), DB::raw('SUM(d.varian_price * d.quantity) as Net'))
            ->leftJoin('transaction__order_detail as d', 'd.order_id', '=', 'transaction__order.order_id')
            ->leftJoin('product__varian as p', 'p.varian_id', '=', 'd.varian_id')
            ->leftJoin('master__member as m', 'm.id', '=', 'transaction__order.agent_id')
            ->where('order_date', '>=', $first)
            ->where('order_date', '<=', $last)
            ->where('status_payment', '=', 1)
            ->groupBy('Agent')
            ->orderBy('Agent')
            ->get();

    $order = 0; $qty = 0; $omzet = 0; $shipping = 0; $net = 0;
    if(!empty($query))
    {
      $array = json_decode(json_encode($query), true);
      foreach ($array as $tmp) {
        $order += $tmp['Total_Order'];
        $qty += $tmp['Quantity'];
        $omzet += $tmp['Omzet'];
        $shipping += $tmp['Shipping'];
        $net += $tmp['Net'];
      }

      $insert = array('Agent' => 'TOTAL', 'Total_Order' => $order, 'Quantity' => $qty, 'Omzet' => $omzet, 'Shipping' => $shipping, 'Net' => $net);
      array_push($array, $insert);

      $data['query'] = $array;
    }
    else
    {
      $data['query'] = 0; 
    }
    
    return view('admin.admin_report_agent', $data);
  }

  //NEW ADMIN
  public function getAdminList()
  {
    $data['active'] = 'adminList';

    return view('admin.admin_admin_list', $data);
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

    return view('admin.admin_add_admin', $data);
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

    return view('admin.admin_edit_admin', $data);
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
    date_default_timezone_set('Asia/Jakarta');
    $data['active'] = 'txOrder';
    $data['first'] = date("Y-m-d", strtotime( "first day of this month"));
    $data['last'] = date("Y-m-d", strtotime( "last day of this month"));
    
    return view('admin.admin_order', $data);
  }

  public function getOrderData(Request $request)
  {
    date_default_timezone_set('Asia/Jakarta');
    $first = date("Y-m-d", strtotime( "first day of this month"));
    $last = date("Y-m-d", strtotime( "last day of this month"));

    $data['query'] = TxOrder::leftJoin('master__member as c', 'customer_id', '=', 'c.id')
                            ->leftJoin('master__member as a', 'agent_id', '=', 'a.id')
                            ->leftJoin('master__city as city', 'city.city_id', '=', 'ship_city_id')
                            ->get(['bank_code' ,'payment_method', 'payment_account' ,'order_id', 'shipping_fee', 'total' ,'group_id', 'shipping_date', 'status_shipping', 'a.name as agent', 'c.name as customer', 'order_date', 'ship_address', 'city_name', 'status_payment', 'status_confirmed', 'who']);
        

    return Datatables::of($data['query'])
    ->filter(function ($instance) use ($request, $first, $last) {
                if ($request->has('dateStart')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if($row['order_date'] >= $request->dateStart) return true;
                        return false;
                    });
                }
                else
                {
                  $instance->collection = $instance->collection->filter(function ($row) use ($first) {
                      if($row['order_date'] >= $first) return true;
                      return false;
                  });
                }

                if ($request->has('dateEnd')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if($row['order_date'] <= $request->dateEnd) return true;
                        return false;
                    });
                }
                else
                {
                  $instance->collection = $instance->collection->filter(function ($row) use ($last) {
                      if($row['order_date'] <= $last) return true;
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
                        if($row['order_id'] == $request->id) return true;
                        return false;
                    });
                }

                //buat group id
                if ($request->has('gId')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if($row['group_id'] == $request->gId) return true;
                        return false;
                    });
                }

                if ($request->has('payment')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if($row['status_payment'] == $request->payment) return true;
                        return false;
                    });
                }

                //kofirmasi penerimaan barang
                if ($request->has('confirm')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if($row['status_confirmed'] == $request->confirm) return true;
                        return false;
                    });
                }

                if ($request->has('ship')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if($row['status_shipping'] == $request->ship) return true;
                        return false;
                    });
                }

                if ($request->has('type')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if(stripos($row['who'], $request->type) !== false) return true;
                        return false;
                    });
                }
            })
    ->editColumn('payment_method', function($data){ 
        if(is_null($data->payment_method)) return "";
        else if($data->payment_method == 0) return "Bank Transfer";
        else if($data->payment_method == 1) return "ATM Bersama";
        else if($data->payment_method == 4) return "Credit Card";
    })
    ->make(true);
  }

  public function getEditOrder($tmp)
  {
    $id = filter_var($tmp, FILTER_SANITIZE_STRING);
    $data['query'] = TxOrder::leftJoin('master__member as c', 'customer_id', '=', 'c.id')
                            ->leftJoin('master__member as a', 'agent_id', '=', 'a.id')
                            ->where('order_id', $id)
                            ->get(['status_shipping' , 'group_id' ,'order_id', 'c.name as cust', 'a.name as agent', 'order_date', 'status_payment' ,'status_confirmed']);
    
    $data['active'] = 'txOrder';

    return view('admin.admin_edit_order', $data);
  }

  public function postEditOrder(Request $request, $id)
  {
    $id = filter_var($id, FILTER_SANITIZE_STRING);
    $v = Validator::make($request->all(), [
        'payment'    => 'required|numeric',
        'confirmed'    => 'required|numeric',
        'ship'    => 'required|numeric',
    ]);

    if ($v->fails())
    {
        return redirect('/admin/edit/order/' . $id)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();
    $confirmed = filter_var($input['confirmed'], FILTER_SANITIZE_STRING);
    $payment = filter_var($input['payment'], FILTER_SANITIZE_STRING);
    $ship = filter_var($input['ship'], FILTER_SANITIZE_STRING);

    $tmp = TxOrder::find($id);
    $order = TxOrder::where('group_id', $tmp->group_id)->get();

    DB::transaction(function() use ($order, $confirmed, $payment, $ship)
    {
      foreach ($order as $data) {
        $data->status_confirmed = $confirmed;
        $data->status_payment = $payment;
        $data->status_shipping = $ship;
        $data->save();
      }
    });

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
  //ORDER CONFIRMATION
  public function getOrderConfirm()
  {
    $data['active'] = 'txOrderConfirm';

    return view('admin.admin_order_confirm', $data);
  }

  public function getOrderConfirmData()
  {
    $data['query'] = TxOrderConfirmation::where('confirmation_status', 0)
                                        ->get(['confirmation_id', 'group_id', 'payment_date', 'amount', 'account_name', 'account_number', 'confirmation_status']);
        
    return Datatables::of($data['query'])
    ->make(true); 
  }

  public function processOrderConfirmation(Request $request)
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

    DB::transaction(function() use ($id)
    {
      $confirm = TxOrderConfirmation::find($id);
      $confirm->confirmation_status = 1;
      $confirm->save();

      $order = TxOrder::where('group_id', $confirm->group_id)->get();
      foreach ($order as $data) {
        $data->status_payment = 1;
        $data->save();
      }
    });

    return 1;
  }

  public function getCutOffDate()
  {
    $data['active'] = 'cutOffDate';
    $data['query'] = CutOffDate::find(1);
    
    return view('admin.admin_cut_off_date', $data);
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

    return view('admin.admin_aboutus', $data);
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

    return view('admin.admin_city', $data);
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

    return view('admin.admin_edit_city', $data);
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

    return view('admin.admin_insert_city', $data);
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

    return view('admin.admin_review_comment', $data);
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

    return view('admin.admin_review_comment_request', $data);
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

  public function getAgentRequestList()
  {
      $data['active'] = "userAgentRequest";

      return view('admin.admin_agent_request', $data);
  }

  public function getAgentRequestData()
  {
      $data['query'] = Req_agent::leftJoin('master__member', 'member_id', '=', 'master__member.id')
                                ->leftJoin('master__city', 'master__member.city_id', '=', 'master__city.city_id')
                                ->leftJoin('master__bank', 'master__bank.bank_id', '=', 'master__member.bank_id')
                                ->where('status_confirm', 0)
                                ->get(['reqagent_id', 'name', 'date_of_birth', 'city_name', 'address', 'phone', 'email', 'bank_name', 'master__req_agent.bank_account as accno']);
        
      return Datatables::of($data['query'])
      ->make(true);
  }

  public function getProcessAgentRequest(Request $request)
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
          Req_agent::find($id)->delete();
          Session::flash('reject', 1);
        }
        else if($action == "approve")
        {
          $request = Req_agent::find($id);
          $request->status_confirm = 1;

          $agentId = $request->member_id;
          $agent = Member::find($agentId);
          $agent->status_user = 0;
          $agent->bank_id = $request->bank_id;
          $agent->bank_account = $request->bank_account;
          $agent->balance = 0;

          $agent->save();
          $request->save();

          Session::flash('approve', 1);
        }
      }
    }
    else
    {
      $id = filter_var($input['id'], FILTER_SANITIZE_STRING);
      if($action == "reject")
      {
        Req_agent::find($id)->delete();
        Session::flash('reject', 1);
      }
      else if($action == "approve")
      {
        $request = Req_agent::find($id);
        $request->status_confirm = 1;

        $agentId = $request->member_id;
        $agent = Member::find($agentId);
        $agent->status_user = 0;
        $agent->bank_id = $request->bank_id;
        $agent->bank_account = $request->bank_account;
        $agent->balance = 0;

        $agent->save();
        $request->save();

        Session::flash('approve', 1);
      }
    }

    return 1;
  }  

  public function getAgentList()
  {
      $data['active'] = "userAgentList";

      return view('admin.admin_agent', $data);
  }

  public function getAgentData()
  {
    $query = DB::table('master__member')
          ->select(DB::raw('AVG(rating) as rating'),'country', 'zipcode' ,'bank_name', 'id', 'name', 'address', 'master__member.city_id', 'date_of_birth', 'email', 'phone', 'verification', 'balance', 'bank_account','city_name')
          ->leftJoin('master__city', 'master__member.city_id', '=', 'master__city.city_id')
          ->leftJoin('master__bank', 'master__member.bank_id', '=', 'master__bank.bank_id')
          ->leftJoin('master__agent_rating', 'master__member.id', '=', 'master__agent_rating.agent_id')
          ->where('status_user', 0)
          ->groupBy('id')
          ->get();


    $data['query'] = new Collection;

    foreach ($query as $value) {
      $data['query']->push([
            'country'         => $value->country,
            'zipcode'       => $value->zipcode,
            'bank_name'      => $value->bank_name,
            'id'      => $value->id,
            'name'      => $value->name,
            'address'      => $value->address,
            'date_of_birth'      => $value->date_of_birth,
            'email'      => $value->email,
            'phone'      => $value->phone,
            'verification'      => $value->verification,
            'balance'      => $value->balance,
            'bank_account'      => $value->bank_account,
            'city_name'      => $value->city_name,
            'rating'      => $value->rating,
        ]);
    }
    
    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getEditAgent($id)
  {
    $data['query'] = Member::find($id);
    $data['active'] = "userAgentList";

    return view('admin.admin_edit_agent', $data);
  }

  public function postEditAgent(Request $request, $id)
  {
    $v = Validator::make($request->all(), [
        'status'       => 'required|numeric',
        'verification' => 'required|numeric',
    ]);    

    if ($v->fails())
    {
        return redirect('/admin/edit/agent/' . $id)->withErrors($v->errors())->withInput();
    }    

    $input = $request->all();

    $status = filter_var($input['status'], FILTER_SANITIZE_STRING);
    $verification = filter_var($input['verification'], FILTER_SANITIZE_STRING);

    $user = Member::find($id);
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
                            ->get(['order_id', 'group_id', 'a.name as agent', 'c.name as customer', 'order_date', 'ship_address', 'city_name', 'status_payment', 'status_confirmed', 'who']);
        
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
                            ->get(['order_id', 'group_id', 'a.id as AId', 'c.name as cust', 'a.name as agent', 'order_date', 'status_payment' ,'status_confirmed']);

    return view('admin.admin_edit_agent_tx', $data);
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

    $tmp = TxOrder::find($orderId);
    $order = TxOrder::where('group_id', $tmp->group_id)->get();

    DB::transaction(function() use ($order, $confirmed, $payment)
    {
      foreach ($order as $data) {
        $data->status_confirmed = $confirmed;
        $data->status_payment = $payment;
        $data->save();
      }
    });
    Session::flash('update', 1);

    return redirect('/admin/edit/agent/' . $AId);
  }

  public function getCustomerList()
  {
      $data['active'] = "userMemberList";

      return view('admin.admin_customer', $data);
  }

  public function getCustomerData()
  {
      $data['query'] = Member::leftJoin('master__city', 'master__member.city_id', '=', 'master__city.city_id')
                            ->where('status_user', 1)
                            ->get(['country', 'zipcode' ,'id', 'name', 'address', 'master__member.city_id', 'date_of_birth', 'email', 'phone', 'verification', 'city_name']);
        
      return Datatables::of($data['query'])
      ->make(true);
  }

  public function getEditCustomer($id)
  {
    $data['active'] = "userMemberList";
    $data['query'] = Member::find($id);

    return view('admin.admin_edit_customer', $data);
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

    $user = Member::find($id);
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
                            ->get(['order_id', 'group_id', 'a.name as agent', 'c.name as customer', 'order_date', 'ship_address', 'city_name', 'status_payment', 'status_confirmed', 'who']);
        
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
                            ->get(['order_id', 'group_id', 'c.id as CId', 'c.name as cust', 'a.name as agent', 'order_date', 'status_payment' ,'status_confirmed']);

    return view('admin.admin_edit_customer_tx', $data);
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

    $tmp = TxOrder::find($orderId);
    $order = TxOrder::where('group_id', $tmp->group_id)->get();

    DB::transaction(function() use ($order, $confirmed, $payment)
    {
      foreach ($order as $data) {
        $data->status_confirmed = $confirmed;
        $data->status_payment = $payment;
        $data->save();
      }
    });

    Session::flash('update', 1);

    return redirect('/admin/edit/customer/' . $CId);
  }

  //fungsi buat FAQ
  public function getFaqList()
  {
      $data['active'] = "faqList";

      return view('admin.admin_faq', $data);
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

    return view('admin.admin_edit_faq', $data);
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

    /*$question = filter_var($input['question'], FILTER_SANITIZE_STRING);
    $answer = filter_var($input['answer'], FILTER_SANITIZE_STRING);*/
    $question = $input['question'];
    $question = str_replace('<p>', '', $question);
    $question = str_replace('</p>', '', $question);
    

    $answer = $input['answer'];
    $answer = str_replace('<p>', '', $answer);
    $answer = str_replace('</p>', '', $answer);

    $faq = Faq::find($id);
    $faq->question = $question;
    $faq->answer = $answer;
    $faq->save();
    Session::flash('update', 1);
    return redirect('/admin/faq/list');
  }

  public function getInsertFaq()
  {
    $data['active'] = 'insertFaq';

    return view ('admin.admin_insert_faq', $data);
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

    /*$question = filter_var($input['question'], FILTER_SANITIZE_STRING);
    $answer = filter_var($input['answer'], FILTER_SANITIZE_STRING);*/
    $question = $input['question'];
    $question = str_replace('<p>', '', $question);
    $question = str_replace('</p>', '', $question);
    

    $answer = $input['answer'];
    $answer = str_replace('<p>', '', $answer);
    $answer = str_replace('</p>', '', $answer);

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

    return view('admin.admin_sample_request', $data);
  }

  public function getSampleData()
  {
    date_default_timezone_set('Asia/Jakarta');
    $today = new \DateTime(NULL);
    $date = date_format($today,"Y-m-d");

    $data['query'] = SampleRequest::leftJoin('master__member as m', 'm.id', '=', 'agent_id')
                                    ->where('approval', 0)
                                    ->where('shipping_date', '>=', $date)
                                    ->get(['shipping_date', 'phone' ,'transaction__sample_request.request_id', 'name', 'event_name', 'event_date', 'event_venue', 'event_description', 'request_date']);

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

    date_default_timezone_set('Asia/Jakarta');
    $date_order = new  \DateTime();
    $order_date = date_format($date_order, "Y-m-d H:i:s");

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
          DB::transaction(function() use ($id)
          {
            //approve di tabel sample
            $sample = SampleRequest::find($id);
            $sample->approval = 1;
            $sample->save();

            //ambil data agent
            $agent = Member::find($sample->agent_id);

            //ambil group id
            $orderData = TxOrder::orderBy('order_id', 'desc')->first();
            $groupId;

            if(empty($orderData))
              $groupId = 1;
            else
            {
              $groupId = ($orderData->group_id) + 1;
            }    

            //bikin order
            $order = new TxOrder();
            $order->customer_id = $order->agent_id = $sample->agent_id;
            $order->ship_address = $agent->address;
            $order->ship_city_id = $agent->city_id;
            $order->shipping_date = $sample->shipping_date;
            $order->group_id = $groupId;
            $order->shipping_fee = 0;
            $order->total = 0;
            $order->who = 'single';
            $order->order_date = $order_date;
            $order->save();

            //bikin order detail
            $detail = SampleDetail::where('request_id', $id)->get();

            foreach ($detail as $data) {
              $tmp = new TxOrderDetail();
              $tmp->order_id = $order->order_id;
              $tmp->varian_id = $data->varian_id;
              $tmp->varian_price = 0;
              $tmp->quantity = $data->quantity;
              $tmp->save();
            }

            Session::flash('approve', 1);
          });          
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
        DB::transaction(function() use ($id)
        {
          //approve di tabel sample
          $sample = SampleRequest::find($id);
          $sample->approval = 1;
          $sample->save();

          //ambil data agent
          $agent = Member::find($sample->agent_id);

          //ambil group id
          $orderData = TxOrder::orderBy('order_id', 'desc')->first();
          $groupId;

          if(empty($orderData))
            $groupId = 1;
          else
          {
            $groupId = ($orderData->group_id) + 1;
          }    

          //bikin order
          $order = new TxOrder();
          $order->customer_id = $order->agent_id = $sample->agent_id;
          $order->ship_address = $agent->address;
          $order->ship_city_id = $agent->city_id;
          $order->shipping_date = $sample->shipping_date;
          $order->group_id = $groupId;
          $order->shipping_fee = 0;
          $order->total = 0;
          $order->who = 'single';
          $order->order_date = $order_date;
          $order->save();

          //bikin order detail
          $detail = SampleDetail::where('request_id', $id)->get();
          
          foreach ($detail as $data) {
            $tmp = new TxOrderDetail();
            $tmp->order_id = $order->order_id;
            $tmp->varian_id = $data->varian_id;
            $tmp->varian_price = 0;
            $tmp->quantity = $data->quantity;
            $tmp->save();
          }

          Session::flash('approve', 1);
        });
      }
    }

    return 1;
  }

  public function getTestimonialList()
  {
    $data['active'] = 'productTestimonial';
    
    return view('admin.admin_product_testimonial', $data);
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

    return view('admin.admin_product_testimonial_request', $data);
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

    return view('admin.admin_product_category', $data);
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

    return view('admin.admin_edit_category', $data);
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

    return view('admin.admin_product', $data);
  }

  public function getProductData()
  {
    $data['query'] = Product::leftJoin('product__category', 'product__category.category_id', '=', 'product__varian.category_id')
                            ->get(['category_name', 'varian_id', 'varian_name', 'price', 'qty', 'picture', 'weight', 'product__varian.description']);
    
    return Datatables::of($data['query'])
    ->make(true);
  }

  public function getInsertProduct()
  {
    $data['query'] = ProductCategory::get(['category_id', 'category_name']);
    $data['active'] = "insertProduct";

    return view('admin.admin_insert_product', $data);
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

    return view('admin.admin_edit_product', $data);
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
    return redirect('/admin/product/list');
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


