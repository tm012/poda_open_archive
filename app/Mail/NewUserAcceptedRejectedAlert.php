<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserAcceptedRejectedAlert extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $email;
    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$email,$status)
    {
        //
        $this->name = $name;
        $this->email = $email;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new_user_accept_reject_email');
    }
}
