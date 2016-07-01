<?php

namespace App\Http\Controllers\Auth;

use App\Member;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\City;
use Cart;
use Auth;
use App\AboutUs;
use App\ActivationService;

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
    protected $activationService;
    
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */

    public function logout()
    {
        Cart::instance('single')->destroy();
        Cart::instance('subcriber')->destroy();
        Auth::guard($this->getGuard())->logout();


        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    public function __construct(ActivationService $activationService)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->activationService = $activationService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function getRegister()
    {
        return $this->showRegistrationForm();
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }
        $data['contact'] = AboutUs::first();
        $data['city'] = City::all();

        return view('auth.register', $data);
    }
    public function showLoginForm()
    {
        $view = property_exists($this, 'loginView')
                    ? $this->loginView : 'auth.authenticate';

        if (view()->exists($view)) {
            return view($view);
        }

        return view('auth.login');
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }


        $sender = 'admin@gocgod.com';
        

        $user = $this->create($request->all());
        $this->activationService->sendActivationMail($user, $sender);

        return redirect('/register')->with('status', 'Kode aktivasi telah dikirim. Silahkan cek email Anda.');
    }

    public function activateUser($token)
    {
        /*if ($user = $this->activationService->activateUser($token)) {
            Auth::guard($this->getGuard())->login($user);
        }*/
        $this->activationService->activateUser($token);
        return redirect('/home')->with('active', 'Akun sudah teraktivasi. Silahkan sign in.');
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

        //cek udh aktivasi lewat email/blom
        $query = Member::where('email', $credentials['email'])->first();
        $activate = $query->verification;

        if($activate)
        {
            if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
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
        return redirect('/register')->with('warning', 'Akun anda harus diaktivasi terlebih dahulu. Kode aktivasi telah dikirim, silahkan cek email Anda.');
    }

    protected function validator(array $data)
    {    
        return Validator::make($data, [
            'name' => 'required|max:255',
            'address' => 'required|max:500',
            'zipcode' => 'required|max:50',
            'dob' => 'required|max:10',
            'phone' => 'required|numeric',
            'email' => 'required|email|max:255|unique:master__member',
            'passwords' => 'required|min:3|confirmed',
            'city' => 'required|numeric',
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
        if($data['city'] == 0)
        {
            $newcity = filter_var($data['newcity'], FILTER_SANITIZE_STRING);

            $city = new City;
            $city->city_name = $newcity;
            $city->save();

            return Member::create([
                'name' => $data['name'],
                'address' => $data['address'],
                'zipcode' => $data['zipcode'],
                'date_of_birth' => $data['dob'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'password' => bcrypt($data['passwords']),
                'city_id' => $city->city_id,
            ]);
        }
        else
        {
            return Member::create([
                'name' => $data['name'],
                'address' => $data['address'],
                'zipcode' => $data['zipcode'],
                'date_of_birth' => $data['dob'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'password' => bcrypt($data['passwords']),
                'city_id' => $data['city'],
            ]);
        }
    }
}
