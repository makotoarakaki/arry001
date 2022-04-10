<?php

namespace App\Http\Controllers\Dashboard;

use DateTime;
use App\MailStand;
use App\User;
use App\Event;
use App\Ticket;
use App\SellingEvent;
use App\SearchUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MailStandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_query = [];
        $sorted = "";

        if ($request->sort !== null) {
            $slices = explode(' ', $request->sort);
            $sort_query[$slices[0]] = $slices[1];
            $sorted = $request->sort;
        }

        if ($request->keyword !== null) {
            $keyword = rtrim($request->keyword);
            $total_count = MailStand::where('title', 'like', "%{$keyword}%")->orwhere('id', "{$keyword}")->count();

            $mails = MailStand::where('title', 'like', "%{$keyword}%")->orwhere('id', "{$keyword}")->sortable($sort_query)->paginate(15);
        } else {
            $keyword = "";
            $total_count = MailStand::count();
            $mails = MailStand::sortable($sort_query)->paginate(15);
        }

        $sort = [
            '古い順' => 'updated_at asc',
            '新しい順' => 'updated_at desc'
        ];

        return view('dashboard.mailstands.index', compact('mails', 'sort', 'sorted', 'total_count', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $event_id = $request->event_id;
        $tickets_id = $request->ticket;

        // イベント取得
        $event = Event::where('id', '=', $event_id)->first();

        $tickets = array();
        if(!is_null($tickets_id)) {
            $tickets = array();
            foreach($tickets_id as $val) {
                $tickets[] = Ticket::where('id', '=', $val)->first();
            }
        }
        return view('dashboard.mailstands.create', compact('event', 'tickets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sendmail = new MailStand();

        $title = $request->input('title');
        $sendmail->title = $title;
        $comment = $request->input('comment');
        $sendmail->comment = $comment;
        if ($request->input('send') == '1') {
            $d = new DateTime();
            $sendmail->send_datetime = $d->modify('+9 hour')->format('Y-m-d H:i');
        } else {
            $d = new DateTime($request->input('date').' '.$request->input('time'));
            $sendmail->send_datetime = $d->format('Y-m-d H:i');
        }
        if ($request->input('send') == '2') {
            $sendmail->send = 2;
        }

        $event_id = $request->input('event_id');
        $ticket_names = $request->input('ticket_name');
        if (!is_null($event_id)) {
            $sendmail->send = 3;
        }

        $sendmail->save(); // データ登録

        /**
         * 条件設定がある場合
         */
 
        if(!is_null($event_id)) {
            $users_id = SellingEvent::where('event_id', '=', $event_id)
                ->whereIn('ticket_name', $ticket_names)->get('user_id');
            // ユーザーIDを配列にする
            $id_array = array();
            foreach($users_id as $val) {
                $id_array[] = $val->user_id;
            }
            if (empty($id_array)) {
                $error = '対象のユーザーがいませんでした。';
                return view('dashboard.mailstands.create', compact('error'));
            }

            // ユーザー情報取得
            $users = User::whereIn('id', $id_array)->get();
            // メルマガスタンドの最新のidを取得
            $mail_stand = MailStand::latest()->first('id');

            // 送信ユーザーを登録する
            foreach($users as $user) {
                $search_user = new SearchUser();
                $search_user->name = $user->name;
                $search_user->kana = $user->kana;
                $search_user->email = $user->email;
                $search_user->mail_stand_id = $mail_stand->id;

                $search_user->save();    
            }
        }
 
        // 今すぐメール送信
        if ($request->input('send') == '1') {
            // 条件あり
            if(!is_null($event_id)) {
                $users = SearchUser::where('mail_stand_id', '=', $mail_stand->id)->get();
            } else {
                // 全ユーザー取得
                $users = User::all();
            }

            // メール送信準備
            $sendmail = app()->make('App\Http\Controllers\SendMailController');

            foreach($users as $user) {
                $sendmail->send($user->email, $user->name, $title, $comment);
            }
        }

        return redirect()->route('dashboard.mailstands.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MailStand  $mailStand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $values = "";
        $show = "";
        if ($id === '1') {
            // イベントを検索
            $values = Event::all();

            $tickets = array();
            foreach($values as $val) {
                $tickets[] = Event::find($val->id)->tickets->all();
            }
            $show = '1';
        } else {
            // 登録ユーザー検索
            $values = User::all();
            $show = '2';
        }

        return view('dashboard.mailstands.condition', compact('values', 'tickets', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MailStand  $mailStand
     * @return \Illuminate\Http\Response
     */
    public function edit(MailStand $mailStand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MailStand  $mailStand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MailStand $mailStand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MailStand  $mailStand
     * @return \Illuminate\Http\Response
     */
    public function destroy(MailStand $mailStand)
    {
        $mailStand->delete();

        return redirect()->route('dashboard.mailstands.index');
    }

    /**
     * 
     */
    public function condition()
    {
        $values = [];
        $show = "";

        return view('dashboard.mailstands.condition', compact('values', 'show'));
    }
}
