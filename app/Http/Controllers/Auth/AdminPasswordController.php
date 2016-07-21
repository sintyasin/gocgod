<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Contracts\Auth\PasswordBroker as PasswordBrokerContract;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Config;
use App\AboutUs;
use Mail;

class AdminPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $redirectTo = 'admin/order';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('admin');
        Config::set("auth.defaults.passwords","admin");
    }

    public function showLinkRequestForm()
    {
        if (property_exists($this, 'linkRequestView')) {
            return view($this->linkRequestView);
        }

        return view('admin.admin_passwords_email');
    }

    public function showResetForm(Request $request, $token = null)
    {
        if (is_null($token)) {
            return $this->getEmail();
        }

        $input = $request->all();
        $email = $input['email'];

        if (property_exists($this, 'resetView')) {
            return view($this->resetView)->with(compact('token', 'email'));
        }

        if (view()->exists('auth.passwords.admin_reset')) {
            return view('auth.passwords.admin_reset')->with(compact('token', 'email'));
        }

        return view('auth.reset')->with(compact('token', 'email'));
    }

    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => bcrypt($password),
            'remember_token' => Str::random(60),
        ])->save();

        auth('admin')->login($user);
    }

    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : 'admin/order';
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateSendResetLinkEmail($request);

        $broker = $this->getBroker();

        $credentials = $this->getSendResetLinkEmailCredentials($request);
        $user = Password::broker()->getUser($credentials);

        $response;

        if (is_null($user)) {
            $response = PasswordBrokerContract::INVALID_USER;
        }
        else
        {
            $data['token'] = Password::broker()->createToken($user);
            $data['email'] = $user->email;
            $data['name'] = $user->name;
            $data['contact'] = AboutUs::first();

            Mail::send('admin.email_reset_password', $data, function ($m) use ($user) {
              $m->from('gocgod@gocgod.com', 'noreply-gocgod');

              $m->to($user->email, $user->name)->subject('Atur ulang password GoCGoD.com Anda');
            });
            
            $response = PasswordBrokerContract::RESET_LINK_SENT;
        }        

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return $this->getSendResetLinkEmailSuccessResponse($response);
            case Password::INVALID_USER: 
            default: 
                return $this->getSendResetLinkEmailFailureResponse($response);
        }
    }
}
