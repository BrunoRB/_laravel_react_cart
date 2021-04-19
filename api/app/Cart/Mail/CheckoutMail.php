<?php

namespace App\Cart\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CheckoutMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cartData;

    public function __construct(array $cartData)
    {
        $this->cartData = $cartData;
    }


    public function build()
    {
        return $this->from('example@example.com')
            ->to(config('morsum.checkout_address'))
            ->view('mail.checkout');
    }
}
