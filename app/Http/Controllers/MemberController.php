<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SignUpRequest;
use App\Http\Requests\LoginRequest;
use App\UserModel;

use Hash;

class MemberController extends Controller
{
    public function registerMemberPage()
    {
    	return view('testing.register');
    }

    public function registerAdminPage()
    {
    	return view('testing.registerAdmin');
    }

    public function checkLoginMember(LoginRequest $request)
    {
    	$email = $request->input('email');
    	$password = Hash::make($request->input('password'));

    	if (Hash::check('abc', $password))
		{
		    echo "login";
		}
		else
		{
			echo "gagal";
		}
    }

    public function loginPageMember()
    {
    	return view('testing.loginMember');
    }

    public function registerAdmin(SignUpRequest $request)
    {
		$name = $request->input('name');
		$cityId = $request->input('city');

		$address = $request->input('address');
		$dob = $request->input('date_of_birth');
		$email = $request->input('address');
		$phone = $request->input('address');
		$password = Hash::make($request->input('address'));

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

    public function registerMember(SignUpRequest $request)
    {
		$name = $request->input('name');
		$cityId = $request->input('city');

		$address = $request->input('address');
		$dob = $request->input('date_of_birth');
		$email = $request->input('address');
		$phone = $request->input('address');
		$password = Hash::make($request->input('address'));
		$bank = $request->input('bank_account');
		$status = $request->input('status_user');

		echo $name . " " . $cityId;

		/*
		$user = new UserModel;
		$user->name = $name;
		$user->city_id = $cityId;
		$user->address = $address;
		$user->date_of_birth = $dob;
		$user->email = $email;
		$user->phone = $phone;
		$user->password = $password;
		$user->bank_account = $bank;
		$user->status_user = $status;
		$user->save();*/
    }
}