<?php

namespace VCComponent\Laravel\Order\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $order)
    {
        $this->email = $email;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Đặt hàng thành công !')->view('order::Mail.Mail');
    }
}
