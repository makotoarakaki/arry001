<?php

namespace App\Http\Controllers\Dashboard;

use App\SellingEvent;
use App\Event;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SellingEventController extends Controller
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
            $total_count = Event::where('title', 'like', "%{$keyword}%")->orwhere('id', "{$keyword}")->count();
            $events = Event::where('title', 'like', "%{$keyword}%")->orwhere('id', "{$keyword}")->sortable($sort_query)->paginate(15);
        } else {
            $keyword = "";
            $total_count = Event::count();
            $events = Event::sortable($sort_query)->paginate(15);
        }

        $sort = [
            '古い順' => 'updated_at asc',
            '新しい順' => 'updated_at desc'
        ];

        return view('dashboard.sellingevents.index', compact('events', 'sort', 'sorted', 'total_count', 'keyword'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SellingEvent  $sellingEvent
     * @return \Illuminate\Http\Response
     */
    public function show($event_id, Request $request)
    {
        $title = $request->input('title');

        $sellingEvents = SellingEvent::where('event_id', $event_id)->get();
        
        $sellings = array();
        $total = 0;
        foreach($sellingEvents as $values) {
            $user = User::find($values->user_id);
            $user_name = '';
            $email = '';
            if(!empty($user)) {
                $user_name = $user->name;
                $email = $user->email;
            }
            $pay_method = "";
            if ($values->pay_method == 1) {
                $pay_method = "クレジットカード";
            } else if($values->pay_method == 2) {
                $pay_method = "銀行振込";
            }
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $values->created_at)->format('Y-m-d');
            $sellings[] =
                [
                    'code' => $values->code,
                    'event_date' => $date,
                    'user_name' => $user_name,
                    'email' => $email,
                    'ticket_name' => $values->ticket_name,
                    'pay_method' => $pay_method,
                    'price' => $values->price
                ];
            $total += $values->price;
        }
    
        return view('dashboard.sellingevents.show', compact('title', 'sellings', 'total'));
    }

}
