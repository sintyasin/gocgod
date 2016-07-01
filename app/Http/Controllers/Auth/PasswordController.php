<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

use App\AboutUs;

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
}
