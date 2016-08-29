<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Response;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\LoginRequest;
use App\Member;
use App\Admin;
use App\Province;
use App\District;
use App\City;
use App\Balance;
use Auth;
use App\Bank;
use App\Req_agent;
use App\AboutUs;
use App\Product;
use App\TxOrder;
use App\AgentDay;
use App\AgentShip;
use App\TxOrderDetail;

use Hash;

class MemberController extends Controller
{
    //---------------- PROFILE - Daerah -----------------
    public function city(Request $request)
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
      $data['city'] = City::where('province_id', $id)->orderBy('city_name', 'asc')->get();
      return view('page.city', $data);
    }

    public function district(Request $request)
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
      $data['district'] = District::where('city_id', $id)->orderBy('district_name', 'asc')->get();

      return view ('page.district', $data);
    }

    //---------------- PROFILE - Informasi Akun -----------------
    public function profile(Request $request)
    {
        $data['contact'] = AboutUs::first();
        $data['querybalance'] = Balance::where('agent_id', Auth::user()->id)
                                ->orderBy('created_at', 'desc')
                                ->get();
        $data['bank'] = Bank::all();
        $data['province'] = Province::orderBy('province_name', 'asc')->get();
        $data['province_check'] = Province::where('status', 1)->get();
        $data['origin'] = AgentShip::leftJoin('master__province as mp', 'mp.province_id','=', 'master__agent_ship.province_id')
            ->leftJoin('master__city as mc', 'mc.city_id', '=', 'master__agent_ship.city_id')
            ->leftJoin('master__district as md', 'md.district_id', '=', 'master__agent_ship.district_id')
            ->where('agent_id', Auth::user()->id)
            ->get(['master__agent_ship.province_id as province_id', 'master__agent_ship.city_id as city_id', 'master__agent_ship.district_id as district_id', 'province_name', 'city_name', 'district_name']);

        $data['city'] = City::where('province_id', Auth::user()->province_id)->get();
        $data['district'] = District::where('city_id', Auth::user()->city_id)->get();

        if($request->wantsJson())
        {
            $response = array(
                'type' => 'OK-PROFILE Informasi Akun',
                'data' => array($data['querybalance'], $data['bank'], $data['city']));
            return Response::json(compact('response'));
        }

        return view('page.profile', $data);
    }

    public function data_profile(Request $request)
    {
        $data['province'] = Province::where('province_id', Auth::user()->province_id)->first();
        $data['city'] = City::where('city_id', Auth::user()->city_id)->first();
        $data['district'] = District::where('district_id', Auth::user()->district_id)->first();
        return view('page.data_user', $data);
    }

    public function data_agent(Request $request)
    {
        $data['origin'] = AgentShip::leftJoin('master__province as mp', 'mp.province_id','=', 'master__agent_ship.province_id')
            ->leftJoin('master__city as mc', 'mc.city_id', '=', 'master__agent_ship.city_id')
            ->leftJoin('master__district as md', 'md.district_id', '=', 'master__agent_ship.district_id')
            ->where('agent_id', Auth::user()->id)
            ->get(['province_name', 'city_name', 'district_name']);

        $data['day'] = AgentDay::where('agent_id', Auth::user()->id)->get();
        return view('page.data_agent', $data);
    }

    public function table_total(Request $request)
    {
        $data['querybalance'] = Balance::where('agent_id', Auth::user()->id)
                                ->orderBy('created_at', 'desc')
                                ->get();
        if($request->wantsJson())
        {
            $response = array(
                'type' => 'OK-PROFILE Deposit',
                'data' => $data['querybalance']);
            return Response::json(compact('response'));
        }
        return view('page.total', $data);
    }

    public function change_agentday(Request $input)
    {
        \DB::beginTransaction();
        $v = Validator::make($input->all(),[
            'hari' => 'required|max:100',
            ]);

        if($v->fails())
        {
            \DB::rollBack();
            return redirect('/profile')->with('error', 'Perubahan data tidak berhasil!');
        }

        AgentDay::where('agent_id', Auth::user()->id)->delete();

        $hari = $input['hari'];
        for($i=0; $i< count($hari); $i++)
        {
            $day = new AgentDay;
            $day->agent_id = Auth::user()->id;
            $day->day = $hari[$i];
            $day->save();
        }

        \DB::commit();

        return redirect('/profile')->with('success', 'Perubahan data berhasil!');
    }

    public function change_agentorigin(Request $request)
    {
        \DB::beginTransaction();

        AgentShip::where('agent_id', Auth::user()->id)->delete();

        for($i=0; $i<20; $i++)
        {
            $vl = Validator::make($request->all(), [
                $i.'-provinsi' => 'required|numeric',
                $i.'-kota' => 'required|numeric',
                $i.'-kecamatan' => 'required|numeric',
                ]);

            $input = $request->all();
            $check_id = AgentShip::where('agent_id', Auth::user()->id)->get();
            
            if(!$check_id->isEmpty())
            {
                if($vl->fails())
                {
                    continue;
                }
                else
                {

                    $provinsi = filter_var($input[$i.'-provinsi'], FILTER_SANITIZE_STRING);
                    $kota = filter_var($input[$i.'-kota'], FILTER_SANITIZE_STRING);
                    $kecamatan = filter_var($input[$i.'-kecamatan'], FILTER_SANITIZE_STRING);
                    // $alamat = filter_var($input['alamat'], FILTER_SANITIZE_STRING);

                    $check = AgentShip::where('district_id', $kecamatan)->first();

                    if(!is_null($check))
                    {
                        continue;
                    }
                    else
                    {
                        $daerah = new AgentShip;
                        $daerah->agent_id = Auth::user()->id;
                        $daerah->province_id = $provinsi;
                        $daerah->city_id = $kota;
                        $daerah->district_id = $kecamatan;
                        $daerah->save();
                    }
                }
            }
            else
            {
                if($vl->fails())
                {
                    \DB::rollBack();
                    return redirect('/profile')->with('error', 'Data tidak valid, silahkan mendaftar ulang');
                }

                $provinsi = filter_var($input[$i.'-provinsi'], FILTER_SANITIZE_STRING);
                $kota = filter_var($input[$i.'-kota'], FILTER_SANITIZE_STRING);
                $kecamatan = filter_var($input[$i.'-kecamatan'], FILTER_SANITIZE_STRING);

                $daerah = new AgentShip;
                $daerah->agent_id = Auth::user()->id;
                $daerah->province_id = $provinsi;
                $daerah->city_id = $kota;
                $daerah->district_id = $kecamatan;
                $daerah->save();
            }
        }

        \DB::commit();

        return redirect('/profile')->with('success', 'Perubahan data berhasil!');   
    }

    public function change_bank(Request $input)
    {
        $v = Validator::make($input->all(),[
            'bank' => 'required|numeric',
            'bank_account' => 'required'
            ]);


        $bank = filter_var($input['bank'], FILTER_SANITIZE_STRING);
        $bank_account = filter_var($input['bank_account'], FILTER_SANITIZE_STRING);

        if($v->fails())
        {
            return redirect('/profile')->withErrors($v->errors())->withInput();
        }
        else
        {
            $req = Member::find(Auth::user()->id);
            $req->bank_id = $bank;
            $req->bank_account = $bank_account;
            $req->save();
        }

        return redirect('/profile');
    }

    public function withdrawMoney(Request $data)
    {
        $v = Validator::make($data->all(),[
            'money' => 'required|numeric',
            ]);

        if($v->fails())
        {
            return redirect('/profile')->withErrors($v->errors())->withInput();
        }
        else
        {
            $input = $data->all();

            $id = Auth::user()->id;
            $balance = Auth::user()->balance;
            $money = filter_var($input['money'], FILTER_SANITIZE_STRING);
            if($balance < $money)
            {
                return redirect('/profile')->with('error', 'Silahkan memasukkan jumlah uang kurang atau sama dengan deposit Anda')->withErrors($v->errors())->withInput();
            }
            else
            {
                $withdraw = new Balance;
                $withdraw->agent_id = $id;
                $withdraw->amountMoney = $money;
                $withdraw->balance_type = 0;
                $withdraw->statusTransfer = 0;
                $withdraw->save();

                \DB::table('master__member')
                    ->where('id', Auth::user()->id)
                    ->update(['balance' => $balance-$money]);
            }
        }

        return redirect('/profile')->with('success', 'Permintaan pengambilan uang Anda akan segera diproses!');
    }

    public function edit_password(Request $request)
    {
        $v = Validator::make($request->all(), [
            'pass' => 'required',
            'newpassword' => 'required|min:3|confirmed',
            'newpassword_confirmation' => 'required',
        ]);

        $pass = $request->pass;

        $v->after(function($v) use ($request) {
            if (!Hash::check($request->pass, Auth()->user()->password))
            {
                $v->errors()->add('pass', 'Wrong Password!');
            }
        });

        if ($v->fails())
        {
            return redirect('/profile')->withErrors($v->errors())->withInput();
        }    

        $input = $request->all();

        $member = Member::find(Auth()->user()->id);
        $member->password = Hash::make($request->newpassword);
        $member->save();
        
        return redirect('/profile/');
    }

    public function edit_profile(Request $request)
    {
         $v = Validator::make($request->all(), [
            'provinsi' => 'required|numeric',
            'kota' => 'required|numeric',
            'kecamatan' => 'required|numeric',
            'address' => 'required|max:500',
            'zipcode' => 'required|max:50',
            'phone' => 'numeric',
            'email' => 'required|email',
        ]);

        if ($v->fails())
        {
            return redirect('/profile')->withErrors($v->errors())->withInput();
        }    

        $input = $request->all();

        $province = filter_var($input['provinsi'], FILTER_SANITIZE_STRING);
        $city = filter_var($input['kota'], FILTER_SANITIZE_STRING);
        $district = filter_var($input['kecamatan'], FILTER_SANITIZE_STRING);
        $address = filter_var($input['address'], FILTER_SANITIZE_STRING);
        $zipcode = filter_var($input['zipcode'], FILTER_SANITIZE_STRING);
        $phone = filter_var($input['phone'], FILTER_SANITIZE_STRING);
        $email = filter_var($input['email'], FILTER_SANITIZE_STRING);
        

        // //kalo new city, berarti insert dulu city barunya
        // if($city == 0)
        // {
        //   $newcity = filter_var($input['newcity'], FILTER_SANITIZE_STRING);
          
        //   $data = new City;
        //   $data->city_name = $newcity;
        //   $data->save();
        // }


        $member = Member::find(Auth()->user()->id);
        $member->date_of_birth = Auth::user()->date_of_birth;

        // if($city == 0)
        //     $member->city_id = $data->city_id;
        // else
        $member->province_id = $province;
        $member->district_id = $district;
        $member->city_id = $city;
        $member->address = $address;
        $member->zipcode = $zipcode;
        $member->phone = $phone;
        $member->email = $email;
        $member->save();
        return redirect('/profile/');
    }

    public function readDataMember($id)
    {
        $data['contact'] = AboutUs::first();
    	$data['query'] = Member::find($id);

        

    	return view('page.myaccount', $data);
    }

    public function readAgent(Request $request)
    {
        $data['contact'] = AboutUs::first();


        $data['agent'] = \DB::table('master__member as m')
                    ->leftJoin('master__agent_rating as ar', 'ar.agent_id', '=','m.id')
                    ->leftJoin('master__city as c', 'c.city_id', '=', 'm.city_id')
                    ->select(\DB::raw('sum(rating)/count(rating) as rate'), 'name', 'address', 'phone', 'email', 'city_name')
                    ->where('status_user', 0)
                    ->groupBy('name')
                    ->paginate(10);

        if($request->wantsJson())
        {
            $success = array(
                'type' => 'OK-PRODUCT AGENTLOCATION',
                'message' => 'success',
                'data' => array(
                    'agent' => $data['agent']
                    ));
            return Response::json(compact('success'));
        }

    	return view('page.findalocation', $data);
    }


    public function bank()
    {
        $data['contact'] = AboutUs::first();
        $data['bank'] = Bank::All();
        $data['province'] = Province::where('status', 1)->orderBy('province_name', 'asc')->get();

        $query = Req_agent::where('member_id', Auth::user()->id)->first();

        if(empty($query))
            $data['request'] = 0;
        else
            $data['request'] = 1;
        
        return view('page.becomeanagent', $data);
    }

    public function request_agent(Request $request)
    {
        AgentShip::where('Agent_id', Auth::user()->id)->delete();
        AgentDay::where('Agent_id', Auth::user()->id)->delete();

        $v = Validator::make($request->all(), [
            'bank' => 'required|numeric',
            'bank_account' => 'required|numeric',
            'hari' => 'required|max:100',
        ]);

        if ($v->fails())
        {
            return redirect('becomeanagent')->with('error', 'Data tidak valid, silahkan mendaftar ulang')->withErrors($v->errors())->withInput();
        }    

        $input = $request->all();

        $id = Auth::user()->id;
        $bank = filter_var($input['bank'], FILTER_SANITIZE_STRING);
        $bank_account = filter_var($input['bank_account'], FILTER_SANITIZE_STRING);

        for($i=0; $i<20; $i++)
        {

            $vl = Validator::make($request->all(), [
                $i.'-provinsi' => 'required|numeric',
                $i.'-kota' => 'required|numeric',
                $i.'-kecamatan' => 'required|numeric',
                ]);

            $check_id = AgentShip::where('agent_id', Auth::user()->id)->get();
            
            if(!$check_id->isEmpty())
            {
                if($vl->fails())
                {
                    continue;
                }
                else
                {
                    $provinsi = filter_var($input[$i.'-provinsi'], FILTER_SANITIZE_STRING);
                    $kota = filter_var($input[$i.'-kota'], FILTER_SANITIZE_STRING);
                    $kecamatan = filter_var($input[$i.'-kecamatan'], FILTER_SANITIZE_STRING);
                    // $alamat = filter_var($input['alamat'], FILTER_SANITIZE_STRING);

                    $check = AgentShip::where('district_id', $kecamatan)->first();

                    if(!is_null($check))
                    {
                        continue;
                    }
                    else
                    {
                        $daerah = new AgentShip;
                        $daerah->agent_id = Auth::user()->id;
                        $daerah->province_id = $provinsi;
                        $daerah->city_id = $kota;
                        $daerah->district_id = $kecamatan;
                        $daerah->save();
                    }
                }
            }
            else
            {
                if($vl->fails())
                {
                    return redirect('becomeanagent')->with('error', 'Data tidak valid, silahkan mendaftar ulang')->withErrors($v->errors())->withInput();
                }

                $provinsi = filter_var($input[$i.'-provinsi'], FILTER_SANITIZE_STRING);
                $kota = filter_var($input[$i.'-kota'], FILTER_SANITIZE_STRING);
                $kecamatan = filter_var($input[$i.'-kecamatan'], FILTER_SANITIZE_STRING);

                $daerah = new AgentShip;
                $daerah->agent_id = Auth::user()->id;
                $daerah->province_id = $provinsi;
                $daerah->city_id = $kota;
                $daerah->district_id = $kecamatan;
                $daerah->save();
            }
        }
        
        $hari = $input['hari'];
        for($i=0; $i< count($hari); $i++)
        {
            $day = new AgentDay;
            $day->agent_id = $id;
            $day->day = $hari[$i];
            $day->save();
        }
        $req = new Req_agent;
        $req->member_id = $id;
        $req->bank_id = $bank;
        $req->bank_account = $bank_account;
        $req->save(); 

        return redirect('becomeanagent')->with('success', 'Permintaan menjadi agen telah diterima, pihak Goc God akan menghubungi anda');
    }
}
?>