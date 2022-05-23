<?php

namespace App\Http\Controllers;

use App\Item;
use App\Event;
use App\Ticket;
use App\User;
use App\SellingEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        // データベースからデータを取得
        $event = Event::find($id);
        $tickets = Ticket::where('event_id', $id)->get();

        // イベント日をフォーマット変換
        $edate = date_create($event->event_date);
        $ed = date_format($edate, 'Y年m月d日');

        // 曜日を抽出
        $week = array( "日", "月", "火", "水", "木", "金", "土" );
        $eweek = $week[date_format($edate, 'w')];
        // イベント日 + 曜日
        $event_date = $ed.'（'.$eweek.')';

        // 開始時間
        $etime_from = date_create($event->event_time_from);
        $event_time_from = date_format($etime_from, 'H時i分');

        // 終了時間
        $etime_to = date_create($event->event_time_to);
        $event_time_to = date_format($etime_to, 'H時i分');

        $detail = [
            'event_date' => $event_date, 
            'etime_from' => $event_time_from, 
            'etime_to' => $event_time_to, 
            'venue' => $event->venue, 
            'administrator' => $event->administrator,
        ];

        return view('items.create', compact('detail', 'event', 'tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function input(Request $request)
    {
        $ticket  = $request->input('ticket');
        // id切り出し
        $ticket_id = strstr($ticket, '&', true);
 
        $price = substr(strstr($ticket, '&'), 1); // 商品料金
        $event_id = $request->input('event_id'); // 開催日
        $product_name = $request->input('name'.$ticket_id); // 商品名
        $pay_method = $request->input('pay_method'); // 支払い方法
        if(Auth::user()) {  
            return redirect()->route('items.confirm', compact('event_id', 'product_name', 'price', 'pay_method'));
        }
        return view('items.input', compact('event_id', 'product_name', 'price', 'pay_method'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    public function confirm(Request $request)
    {
        $token = "";
        if (Auth::user()) {
            $user = User::find(Auth::user()->id);
            $token = $user->token;    
        }
  
         $pay_jp_secret = env('PAYJP_SECRET_KEY');
         \Payjp\Payjp::setApiKey($pay_jp_secret);
 
         $card = [];
         $count = 0;
  
         if ($token != "") {
             $result = \Payjp\Customer::retrieve($user->token)->cards->all(array("limit"=>1))->data[0];
             $count = \Payjp\Customer::retrieve($user->token)->cards->all()->count;
  
             $card = [
                 'brand' => $result["brand"],
                 'exp_month' => $result["exp_month"],
                 'exp_year' => $result["exp_year"],
                 'last4' => $result["last4"] 
             ];

        }

        $event_id = $request->input('event_id'); // 開催日
        $product_name = $request->input('product_name'); // 開催日
        $price = $request->input('price');
        $pay_method = $request->input('pay_method'); // 支払い方法

 
        return view('items.confirm', compact('card', 'count', 'event_id', 'product_name', 'price', 'pay_method'));
     }

     public function token(Request $request)
     {
         $pay_jp_secret = env('PAYJP_SECRET_KEY');
         \Payjp\Payjp::setApiKey($pay_jp_secret);
  
         $user = User::find(Auth::user()->id);
         $customer = $user->token;

         if ($customer != "") {
             $cu = \Payjp\Customer::retrieve($customer);
             $delete_card = $cu->cards->retrieve($cu->cards->data[0]["id"]);
             $delete_card->delete();
             $cu->cards->create(array(
                 "card" => request('payjp-token')
             ));
         } else {
             $cu = \Payjp\Customer::create(array(
                 "card" => request('payjp-token')
             ));
             $user->token = $cu->id;
             $user->update();
         } 

         $event_id = $request->input('event_id');
         $product_name = $request->input('product_name');
         $price = $request->input('price');
         $pay_method = $request->input('pay_method'); // 支払い方法

         return redirect()->route('items.confirm', compact('event_id', 'product_name', 'price', 'pay_method'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $price = $request->input('price');

        $selling = new SellingEvent();
        $selling->code = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 6);
        $selling->price = $price;
        $selling->ticket_name = $request->input('product_name');
        $selling->user_id = $user->id;
        $selling->event_id = $request->input('event_id');

        $pay_method = $request->input('pay_method'); // 支払い方法
        $selling->pay_method = $pay_method;

        $selling->save();

        if($pay_method === '1') {
            $pay_jp_secret = env('PAYJP_SECRET_KEY');
            \Payjp\Payjp::setApiKey($pay_jp_secret);
     
            if(empty($user->token)) {
                return redirect()->route('items.confirm');
            }
            $res = \Payjp\Charge::create(
                [
                    "customer" => $user->token,
                    "amount" => $price,
                    "currency" => 'jpy'
                ]
            );    
        }

 
        // データを取得
        $event_id = $request->input('event_id');
        $product_name = $request->input('product_name');
        $price = $request->input('price');

        $event = Event::find($event_id);


        $ticket = Ticket::where('name', $product_name)->first();
        $ticket->number_sales = $ticket->number_sales + 1;

        $ticket->update();
 
        // お客様への購入メール送信
        $purchase_mail = app()->make('App\Http\Controllers\PurchaseMailController');
        $purchase_mail->purchas($event, $product_name, $price, $pay_method, $selling->code);

        // 購入後のページへ移動
        return view('items.completion');
    }
}
