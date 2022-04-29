<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Support\Facades\Mail;
use App\Mail\PurchaseMail;

class PurchaseMailController extends Controller
{
    public function purchas(Event $event, $product_name, $price, $pay_method, $code) {

        // データベースより値を取得
        $this->title = $event->title;
        $subtitle = 'この度は、『'.$this->title.'にお申し込みいただきありがとうございます。』';

        $bank_info = "";
        if ($pay_method === '2') {
            $bank_info = "お振込時にお手数ですが下記のコードをお振込名義の前にご記入をお願い致します。\n";
            $bank_info .= $code."\n";
            $bank_info .= "記入例：".$code."山田 太郎\n";
            $bank_info .= "お振込先：\n";
            $bank_info .= "新生銀行\n";
            $bank_info .= "本店 400\n";
            $bank_info .= "普通：2602286\n";
            $bank_info .= "新垣 誠\n";
        } else {
            $bank_info = "クレジット決済";
        }

        // イベント日をフォーマット変換
        $edate = date_create($event->event_date);
        $ed = date_format($edate, 'Y年m月d日');

        // 曜日を抽出
        $week = array( "日", "月", "火", "水", "木", "金", "土" );
        $eweek = $week[date_format($edate, 'w')];
        // イベント日 + 曜日
        $e_date = $ed.'（'.$eweek.')';

        // 開始時間
        $etime_from = date_create($event->event_time_from);
        $event_time_from = date_format($etime_from, 'H時i分');

        // 終了時間
        $etime_to = date_create($event->event_time_to);
        $event_time_to = date_format($etime_to, 'H時i分');

        // 日程
        $this->event_date = $e_date.' '.$event_time_from.'〜'.$event_time_to;

        // 会場
        $this->venue = $event->venue;

        // 講師
        $this->administrator = $event->administrator;

        // 商品名
        $this->product_name = $product_name;

        // 料金
        $this->price = $price;

        Mail::send(new PurchaseMail($this->title, 
                                    $subtitle, 
                                    $this->event_date, 
                                    $this->venue, 
                                    $this->administrator,
                                    $this->product_name,
                                    $this->price,
                                    $bank_info
                ));
    }
}
