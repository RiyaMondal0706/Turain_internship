<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InternshipCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $password;
    public $generate;

    public function __construct($name, $email, $password, $generate)
    {
        $this->name     = $name;
        $this->email    = $email;
        $this->password = $password;
        $this->generate = $generate;
    }

    public function build()
    {
        return $this->from(
            config('mail.from.address'),
            config('mail.from.name')
        )
            ->subject('Internship Login Credentials')
            ->view('emails.internship_credentials');
    }
}
