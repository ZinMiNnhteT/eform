<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserDeleteKeySend extends Mailable
{
    use Queueable, SerializesModels;
    public  $key;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($key)
    {
        $this->key  = $key;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.user_delete_key_send')->with([
            'key'=> $this->key
        ]);
    }
}
