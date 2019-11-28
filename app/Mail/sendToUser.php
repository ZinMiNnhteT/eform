<?php

namespace App\Mail;

use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendToUser extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $mail_body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $mail_body)
    {
        $this->name = $name;
        $this->mail_body = $mail_body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("MOEE Online Meter/Transformer Application")->view('admin.emails.sendToUser');
    }
}
