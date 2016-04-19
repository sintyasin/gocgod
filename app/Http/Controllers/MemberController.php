<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SignUpRequest;
use App\UserModel;

class MemberController extends Controller
{
    public function register()
    {
    	return view('page.register');
    }

    public function registerSubmit(SignUpRequest $request)
    {
		$name = $request->input('name');
		$cityId = $request->input('city');

		$address = $request->input('address');
		$dob = $request->input('date_of_birth');
		$email = $request->input('address');
		$phone = $request->input('address');
		$password = bcrypt($request->input('address'));
		$bank = $request->input('bank_account');
		$status = $request->input('status_user');

		echo $name . " " . $cityId;
		/*
		$user = new UserModel;
		$user->name = $name;
		$user->city_id = $cityId;
		$user->save();*/
    }
}