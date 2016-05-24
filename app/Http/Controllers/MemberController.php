<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SignUpRequest;
use App\Http\Requests\LoginRequest;
use App\Member;
use App\Admin;
use App\City;

use Hash;

class MemberController extends Controller
{
	public function getLoginMember()
    {
    	return view('testing.loginMember');
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
    	return view('testing.registerMember');
    }

    public function getRegisterAdmin()
    {
    	return view('testing.registerAdmin');
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

		/*
		$user = new AdminModel;
		$user->name = $name;
		$user->city_id = $cityId;
		$user->address = $address;
		$user->date_of_birth = $dob;
		$user->email = $email;
		$user->phone = $phone;
		$user->password = $password;
		$user->save();*/
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

		/*
		$user->name = $name;
		$user->address = $address;
		$user->date_of_birth = $dob;
		$user->phone = $phone;
		$user->bank_account = $bank;
		$user->status_user = $status;*/
		$user->save();
    }

    public function readDataMember($id)
    {
    	$data['query'] = Member::find($id);

    	return view('page.myaccount', $data);
    }

    public function readAgent()
    {
    	$data['queryAgent'] = Member::where('status_user', 0)
    								->get();
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
}
