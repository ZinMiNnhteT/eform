<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public  $header, $body, $remark, $link, $link_name, $office_from, $files,$file_path;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($header, $body, $remark, $link, $link_name, $office_from, $files = null, $file_path = null)
    {
        $this->header       = $header;
        $this->body         = $body;
        $this->remark       = $remark;
        $this->link         = $link;
        $this->link_name    = $link_name;
        $this->office_from  = $office_from;
        $this->files        = $files;
        $this->file_path    = $file_path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->view('emails.sendMail')
                    ->from(config('mail.from.address'),config('mail.from.name'))
                    ->subject($this->header);
        
        if($this->files != null && $this->file_path != null){
            foreach ($this->files as $file) { 
                $mail = $mail->attach($this->file_path.$file); 
            }
        }

        return $mail->with([
            'header'            => $this->header,
            'body'              => $this->body,
            'remark'            => $this->remark,
            'link'              => $this->link,
            'link_name'         => $this->link_name,
            'office_from'       => $this->office_from,
        ]);
    }
}
