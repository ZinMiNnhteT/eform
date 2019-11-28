<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentDone extends Mailable
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
        return $this->view('admin.emails.paymentDone');
    }
}
