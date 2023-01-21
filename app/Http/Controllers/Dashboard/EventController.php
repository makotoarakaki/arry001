<?php

namespace App\Http\Controllers\Dashboard;

use App\Event;
use App\Ticket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_query = ["updated_at" => "desc"];
        $sorted = "";
        $sort = [
            '新しい順' => 'updated_at desc',
            '古い順' => 'updated_at asc'
        ];

        if ($request->sort !== null) {
            $slices = explode(' ', $request->sort);
            $sort_query[$slices[0]] = $slices[1];
            $sorted = $request->sort;
        }

        if ($request->keyword !== null) {
            $keyword = rtrim($request->keyword);
            $total_count = Event::where('title', 'like', "%{$keyword}%")->orwhere('id', "{$keyword}")->count();
            $events = Event::where('title', 'like', "%{$keyword}%")->orwhere('id', "{$keyword}")->sortable($sort_query)->paginate(15);
        } else {
            $keyword = "";
            $total_count = Event::count();
            $events = Event::sortable($sort_query)->paginate(15);
        }

        return view('dashboard.events.index', compact('events', 'sort', 'sorted', 'total_count', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $from_mail = config('app.from_mail');

        return view('dashboard.events.create', compact('from_mail'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'comment' => 'required',
        ],
        [
            'title.required' => 'イベント名は必須です。',
            'comment.required' => 'イベント説明は必須です。',
        ]);

        $event = new Event();

        $event->title = $request->input('title');
        $event->comment = $request->input('comment');
        if ($request->file('image') !== null) {
            $image = $request->file('image')->store('public/events');
            $event->image = basename($image);
        } else {
            $event->image = '';
        }
        $event->category_id = $request->input('category_id');
        $event->event_date = $request->input('event_date');
        $event->event_time_from = $request->input('event_time_from');
        $event->event_time_to = $request->input('event_time_to');
        $event->venue = $request->input('venue');
        $event->administrator = $request->input('administrator');
        $pay_m = 0;
        if ($request->input('pay_m1') == 'on') {
            $pay_m = 1;
        }
        if ($request->input('pay_m2') == 'on') {
            $pay_m = 2;
        }
        if($request->input('pay_m1') == 'on' && $request->input('pay_m2') == 'on') {
            $pay_m = 3;
        }
        $event->pay_method = $pay_m;

        $event->save();

        $event_new = Event::orderBy('created_at', 'desc')->first();
        $event_id = $event_new->id;
 
        return redirect()->route('dashboard.tickets.index', compact('event_id'));
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ticket(Request $request)
    {
        $ticket = new Ticket();
        $ticket->id = $request->input('id');
        $pay_m = 0;
        if ($request->input('pay_m1') == 'on') {
            $pay_m++;
        }
        if ($request->input('pay_m2') == 'on') {
            $pay_m++;
        }
        $ticket->pay_method = $pay_m;


        return redirect()->route('show', $ticket->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);

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

        $edate = [
            'event_date' => $event_date, 
            'etime_from' => $event_time_from, 
            'etime_to' => $event_time_to, 
        ];        

        return view('dashboard.events.show', compact('event', 'edate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('dashboard.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required',
            'comment' => 'required',
        ],
        [
            'title.required' => 'イベント名は必須です。',
            'comment.required' => 'イベント説明は必須です。',
        ]);

        $event->title = $request->input('title');
        $event->comment = $request->input('comment');
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('public/events');
            $event->image = basename($image);
        } else if(isset($event->image)) {
            // do nothing
        } else {
            $event->image = '';
        }
        $event->category_id = $request->input('category_id');
        $event->event_date = $request->input('event_date');
        $event->event_time_from = $request->input('event_time_from');
        $event->event_time_to = $request->input('event_time_to');
        $event->venue = $request->input('venue');
        $event->administrator = $request->input('administrator');
        $pay_m = 0;
        if ($request->input('pay_m1') == 'on') {
            $pay_m = 1;
        }
        if ($request->input('pay_m2') == 'on') {
            $pay_m = 2;
        }
        if($request->input('pay_m1') == 'on' && $request->input('pay_m2') == 'on') {
            $pay_m = 3;
        }
        $event->pay_method = $pay_m;

        $event->update();
 
        return redirect()->route('dashboard.events.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('dashboard.events.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function thankyou_email(Request $request, Event $event)
    {
        $event = Event::find($request->input('event_id'));
 //       $event->id = $request->input('event_id');

        return view('dashboard.events.thankyou_email', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function compose_email(Request $request)
    {
        $request->validate([
            'mail_title' => 'required',
            'mail_content' => 'required',
        ],
        [
            'mail_title.required' => '件名は必須です。',
            'mail_content.required' => '本文は必須です。',
        ]);

        $event = Event::find($request->input('id'));
        $event->mail_title = $request->input('mail_title');
        $event->mail_content = $request->input('mail_content');

        $event->update();
 
        return redirect()->route('dashboard.events.index');
    }
}
