<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\LoginRequest;
use App\Member;
use App\Admin;
use App\City;
use App\Balance;
use Auth;
use App\Bank;
use App\Req_agent;
use App\AboutUs;

use Hash;

class MemberController extends Controller
{
	/*public function getLoginMember()
    {
        $data['contact'] = AboutUs::first();
    	return view('testing.loginMember', $data);
    }
    
    public function postLoginMember(LoginRequest $request)
    {
    	$email = $request->input('email');
    	$password = Hash::make($request->input('password'));
    	
    	$query = AdminModel::where('email', '=', $email);

    	if (Hash::check($query->password, $password))
		{
		    echo "login";
		}
		else
		{
			echo "gagal";
		}
    }

    public function getRegisterMember()
    {
        $data['contact'] = AboutUs::first();
    	return view('testing.registerMember', $data);
    }

    public function getRegisterAdmin()
    {
        $data['contact'] = AboutUs::first();
    	return view('testing.registerAdmin', $data);
    }

    public function postRegisterAdmin(SignUpRequest $request)
    {
		$name = $request->input('name');
		$address = $request->input('address');
		$cityId = $request->input('city');

		$dob = $request->input('dob');
		$email = $request->input('email');
		$phone = $request->input('phone');
		$password = Hash::make($request->input('password'));

		echo $name . " " . $cityId;

		
		$user = new AdminModel;
		$user->name = $name;
		$user->city_id = $cityId;
		$user->address = $address;
		$user->date_of_birth = $dob;
		$user->email = $email;
		$user->phone = $phone;
		$user->password = $password;
		$user->save();
    }

    public function postRegisterMember(SignUpRequest $request)
    {
		$name = $request->input('name');
		$cityId = $request->input('city');

		$address = $request->input('address');
		$dob = $request->input('dob');
		$email = $request->input('email');
		$phone = $request->input('phone');
		$password = Hash::make($request->input('password'));
		$bank = $request->input('bank');
		$status = $request->input('status');

		echo $name . " " . $cityId;

		
		$user = new MemberModel;
		$user->email = $email;
		$user->city_id = $cityId;
		$user->password = $password;

		
		$user->name = $name;
		$user->address = $address;
		$user->date_of_birth = $dob;
		$user->phone = $phone;
		$user->bank_account = $bank;
		$user->status_user = $status;
		$user->save();
    }*/

    public function readDataMember($id)
    {
        $data['contact'] = AboutUs::first();
    	$data['query'] = Member::find($id);

    	return view('page.myaccount', $data);
    }

    public function readAgent()
    {
        $data['contact'] = AboutUs::first();
    	$data['queryAgent'] = Member::where('status_user', 0)->get();
    	$i=0;
    	foreach($data['queryAgent'] as $tmp)
    	{
    		$data['queryCity'][$i] = City::find($tmp->city_id); 
			// \DB::table('master__city')->where('city_id', 1)->first();
            $i++;
    	}
    	// dd($data);
    	return view('page.findalocation', $data);


    }

    public function showbalance($id)
    {
        $data['contact'] = AboutUs::first();
		$data['querybalance'] = Balance::where('agent_id', $id)
								->orderBy('created_at', 'desc')
								->get();

        $data['city'] = City::all();

		return view('page.profile', $data);
    }  

    public function withdrawMoney(Request $data)
    {
    	$v = Validator::make($data->all(),[
    		'money' => 'required|numeric',
    		]);

    	if($v->fails())
    	{
    		return redirect('/profile/'.Auth::user()->id)->withErrors($v->errors())->withInput();
    	}
    	else
    	{
    		$input = $data->all();

    		$id = Auth::user()->id;
    		$balance = Auth::user()->balance;
    		$money = filter_var($input['money'], FILTER_SANITIZE_STRING);
    		if($balance < $money)
    		{
    			return redirect('/profile/'.Auth::user()->id)->withErrors('Not valid!')->withInput();
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

    	return redirect('/profile/'.Auth::user()->id);
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
            return redirect('/profile/'.Auth::user()->id)->withErrors($v->errors())->withInput();
        }    

        $input = $request->all();

        $member = Member::find(Auth()->user()->id);
        $member->password = Hash::make($request->newpassword);
        $member->save();
        // dd($request->newpassword);
        return redirect('/profile/'.Auth::user()->id);
    }

    public function edit_profile(Request $request)
    {
    	 $v = Validator::make($request->all(), [
            'city' => 'required|numeric',
            'address' => 'required|max:500',
            'phone' => 'numeric',
            'email' => 'required|email',
        ]);

        if ($v->fails())
        {
            return redirect('/profile/'.Auth::user()->id)->withErrors($v->errors())->withInput();
        }    

        $input = $request->all();

        $city = filter_var($input['city'], FILTER_SANITIZE_STRING);
        $address = filter_var($input['address'], FILTER_SANITIZE_STRING);
        $phone = filter_var($input['phone'], FILTER_SANITIZE_STRING);
        $email = filter_var($input['email'], FILTER_SANITIZE_STRING);
        

        //kalo new city, berarti insert dulu city barunya
        if($city == 0)
        {
          $newcity = filter_var($input['newcity'], FILTER_SANITIZE_STRING);
          
          $data = new City;
          $data->city_name = $newcity;
          $data->save();
        }


        $member = Member::find(Auth()->user()->id);
        $member->date_of_birth = Auth::user()->date_of_birth;

        if($city == 0)
            $member->city_id = $data->city_id;
        else
            $member->city_id = $city;
        $member->address = $address;
        $member->phone = $phone;
        $member->email = $email;
        $member->save();
        return redirect('/profile/'.Auth::user()->id);
    }

    public function bank()
    {
        $data['contact'] = AboutUs::first();
        $data['bank'] = Bank::All();

        return view('page.becomeanagent', $data);
    }

    public function request_agent(Request $request)
    {
         $v = Validator::make($request->all(), [
            'bank' => 'required|numeric',
            'bank_account' => 'required|numeric',
        ]);

        if ($v->fails())
        {
            return redirect('becomeanagent')->withErrors($v->errors())->withInput();
        }    

        $input = $request->all();

        $id = Auth::user()->id;
        $bank = filter_var($input['bank'], FILTER_SANITIZE_STRING);
        $bank_account = filter_var($input['bank_account'], FILTER_SANITIZE_STRING);

        $req = new Req_agent;
        $req->member_id = $id;
        $req->bank_id = $bank;
        $req->bank_account = $bank_account;
        $req->save();
        return redirect('/home');
    }
}
