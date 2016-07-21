<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker as PasswordBrokerContract;
use Mail;

use App\AboutUs;
use App\Member;

class PasswordController extends Controller
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

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        $data['contact'] = AboutUs::first();
        if (is_null($token)) {
            return $this->getEmail();
        }

        $email = $request->input('email');

        if (property_exists($this, 'resetView')) {
            return view($this->resetView, $data)->with(compact('token', 'email'));
        }

        if (view()->exists('auth.passwords.reset')) {
            return view('auth.passwords.reset', $data)->with(compact('token', 'email'));
        }

        return view('auth.reset', $data)->with(compact('token', 'email'));
    }

    public function showLinkRequestForm()
    {
        $data['contact'] = AboutUs::first();
        if (property_exists($this, 'linkRequestView')) {
            return view($this->linkRequestView, $data);
        }

        if (view()->exists('auth.passwords.email')) {
            return view('auth.passwords.email', $data);
        }

        return view('auth.password', $data);
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

            Mail::send('page.email_reset_password', $data, function ($m) use ($user) {
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
