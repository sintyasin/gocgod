<?php

namespace App;


use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Mail;

class ActivationService
{

    protected $mailer;

    protected $activationRepo;

    protected $resendAfter = 24;

    public function __construct(Mailer $mailer, ActivationRepository $activationRepo)
    {
        $this->mailer = $mailer;
        $this->activationRepo = $activationRepo;
    }

    public function sendActivationMail($user, $sender)
    {

        if ($user->activated || !$this->shouldSend($user)) {
            return;
        }

        $token = $this->activationRepo->createActivation($user);

        $link = route('user.activate', $token);        
        
        $data['name'] = $user->name;
        $data['link'] = $link;
        $data['contact'] = AboutUs::first();
        
        Mail::send('page.email_verifikasi', $data, function ($m) use ($user) {
          $m->from('gocgod@gocgod.com', 'noreply-gocgod');

          $m->to($user->email, $user->name)->subject('Aktivasi akun goCgoD');
        });
    }

    public function activateUser($token)
    {
        $activation = $this->activationRepo->getActivationByToken($token);

        if ($activation === null) {
            return null;
        }

        $user = Member::find($activation->user_id);

        $user->verification = 1;

        $user->save();

        $this->activationRepo->deleteActivation($token);

        return $user;
    }

    private function shouldSend($user)
    {
        $activation = $this->activationRepo->getActivation($user);
        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }

}