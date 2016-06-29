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

use App\City;
use App\Admin;
use Hash;

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
    //protected $redirectTo = '/admin/product/list';
    //protected $loginPath = '/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    protected $redirectTo = '/admin/order';

    public function __construct()
    {
        //$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */

    public function getLogin()
    {
        if (auth('admin')->check())
        {
            return redirect('admin/order');
        }
        else
            return view('admin.admin_login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::guard('admin')->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function getLogout()
    {
        if(auth('admin')->check())
        {
            auth('admin')->logout();
            return Redirect::to('/general/log/in');
        }
    }

    public function getEditProfile()
    {
        $data['query'] = auth('admin')->user();
        $data['city'] = City::all();
        
        return view('admin.admin_edit_profile', $data);
    }

    public function postEditProfile(Request $request)
    {
        $v = Validator::make($request->all(), [
            'dob' => 'required',
            'city' => 'required|numeric',
            'address' => 'required|max:500',
            'phone' => 'numeric',
            'email' => 'required|email',
        ]);

        if ($v->fails())
        {
            return redirect('/admin/edit/profile')->withErrors($v->errors())->withInput();
        }    

        $input = $request->all();

        $dob = filter_var($input['dob'], FILTER_SANITIZE_STRING);
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


        $admin = Admin::find(auth('admin')->user()->id);
        $admin->date_of_birth = $dob;

        if($city == 0)
            $admin->city_id = $data->city_id;
        else
            $admin->city_id = $city;
        $admin->address = $address;
        $admin->phone = $phone;
        $admin->email = $email;
        $admin->save();

        Session::flash('update', 1);
        return redirect('/admin/edit/profile');
    }

    public function postChangePassword(Request $request)
    {
        $v = Validator::make($request->all(), [
            'pass' => 'required',
            'newpassword' => 'required|min:3|confirmed',
            'newpassword_confirmation' => 'required',
        ]);

        $pass = $request->pass;

        $v->after(function($v) use ($request) {
            if (!Hash::check($request->pass, auth('admin')->user()->password))
            {
                $v->errors()->add('pass', 'Wrong Password!');
            }
        });

        if ($v->fails())
        {
            return redirect('/admin/edit/profile')->withErrors($v->errors())->withInput();
        }    

        $input = $request->all();

        $admin = Admin::find(auth('admin')->user()->id);
        $admin->password = Hash::make($request->newpassword);
        $admin->save();

        Session::flash('password', 1);
        return redirect('/admin/edit/profile');
    }
}
