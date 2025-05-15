<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $resetLink;
    public $email;

    public function __construct($user)
    {
        $this->user = $user;
        $this->resetLink = url('/reset/password/' . $user->email_verification_token);
        $this->email = $user->email;
    }

    public function build()
    {
        return $this->subject('Reset Password Request')
                    ->view('site.page.emails.reset-password')
                    ->with([
                        'user' => $this->user,
                        'resetLink' => $this->resetLink,
                        'email' => $this->email
                    ]);
    }
}
