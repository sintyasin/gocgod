<?php

namespace App\Http\Controllers\Auth;

use App\Member;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->middleware('admin', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {    
        return Validator::make($data, [
            'name' => 'required|max:255',
            'address' => 'required|max:500',
            'dob' => 'required|max:10',
            'phone' => 'required|numeric',
            'email' => 'required|email|max:255|unique:master__member',
            'password' => 'required|min:3|confirmed',
            'city' => 'required|numeric',
            'userType' => 'required|numeric',
            'bank' => 'required|numeric',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */

    protected function create(array $data)
    {
        return Member::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'date_of_birth' => $data['dob'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'city_id' => $data['city'],
            'status_user' => $data['userType'],
            'bank_account' => $data['bank'],
        ]);
    }
}
