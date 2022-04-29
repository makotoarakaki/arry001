<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;

class PurchaseMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $subtitle, $event_date, $venue, $administrator, $product_name, $price, $bank_info)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->event_date = $event_date;
        $this->venue = $venue;
        $this->administrator = $administrator;
        $this->product_name = $product_name;
        $this->price = $price;
        $this->bank_info = $bank_info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = Auth::user()->email;
        $name = Auth::user()->name;
        $from = config('app.from_mail'); // config.app.phpで定義した値を取得
        $from_name = config('app.from_name'); // config.app.phpで定義した値を取得

        return $this->to($email)
                    ->from($from, $from_name)
                    ->view('emails.purchase')
                    ->with(
                        [
                            'name' => $name, 
                            'title' => $this->title, 
                            'subtitle' => $this->subtitle, 
                            'event_date' => $this->event_date, 
                            'venue' => $this->venue, 
                            'administrator' => $this->administrator, 
                            'product_name' => $this->product_name, 
                            'price' => $this->price,
                            'bank_info' => $this->bank_info,
                        ]
                    )
                    ->subject($this->title.'のお申し込みありがとうございます。');
    }
}
