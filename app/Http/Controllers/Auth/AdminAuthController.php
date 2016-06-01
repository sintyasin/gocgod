<?php

namespace App\Http\Controllers\Auth;

use App\Member;
use Validator;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Redirect;
use Session;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
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
    protected $redirectTo = '/admin/product/list';
    //protected $loginPath = '/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {    
        /*return Validator::make($data, [
            'name' => 'required|max:255',
            'address' => 'required|max:500',
            'dob' => 'required|max:10',
            'phone' => 'required|numeric',
            'email' => 'required|email|max:255|unique:master__member',
            'password' => 'required|min:3|confirmed',
            'city' => 'required|numeric',
            'userType' => 'required|numeric',
            'bank' => 'required|numeric',
        ]);*/
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */

    protected function create(array $data)
    {
        /*return Member::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'date_of_birth' => $data['dob'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'city_id' => $data['city'],
            'status_user' => $data['userType'],
            'bank_account' => $data['bank'],
        ]);*/
    }

    public function getLogin()
    {
        return view('page.admin_login');
    }

    public function postLogin(Request $request)
    {
        // validate the info, create rules for the inputs
        $rules = array(
            'email'    => 'required|email', // make sure the email is an actual email
            'password' => 'required|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect('/admin')->withErrors($validator->errors())->withInput();
        } else {

            // create our user data for the authentication
            $input = $request->all();

            $email = filter_var($input['email'], FILTER_SANITIZE_STRING);
            $password = filter_var($input['password'], FILTER_SANITIZE_STRING);
            
            $userdata = array(
                'email'     => $email,
                'password'  => $password
            );

            // attempt to do the login
            if (Auth::attempt($userdata)) {

                // validation successful!
                // redirect them to the secure section or whatever
                // return Redirect::to('secure');
                // for now we'll just echo success (even though echoing in a controller is bad)
                echo 'SUCCESS!';

            } else {        
                Session::flash('failed', 1);
                // validation not successful, send back to form 
                return Redirect::to('/admin');

            }

        }
    }
}
