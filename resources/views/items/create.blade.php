@extends('layouts.item')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
        <div class="d-flex justify-content-center">
            <!-- <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList"> -->
            <ol class="breadcrumb">
                <li itemprop="itemListElement" itemscope
                    itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="#">
                        <span itemprop="name">入力</span>
                    </a>
                    <meta itemprop="position" content="1" />
                </li>
                <div class="breadcrumb-gray">
                    <li itemprop="itemListElement" itemscope
                        itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="#">
                            <span itemprop="name">確認</span>
                        </a>
                        <meta itemprop="position" content="2" />
                    </li>

                    <li itemprop="itemListElement" itemscope
                        itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="#">
                            <span itemprop="name">完了</span>
                        </a>
                        <meta itemprop="position" content="3" />
                    </li>
                </div>
            </ol>
        </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="samazon-event-title row">
                <h1>{{$event->title}}</h1>
            </div>
            <form method="POST" action="/items/input" class="mb-5" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-inline mt-4 mb-4 row">
                    @if ($event->image !== "")
                        <img src="{{ asset('public/storage/events/'.$event->image) }}" class="img-thumbnail">
                    @else
                        <img src="{{ asset('img/dummy.png')}}" class="img-thumbnail">
                    @endif
                </div>
                <div class="form-inline mt-4 mb-4 row samazon-border-comment">
                    {!! nl2br(htmlspecialchars($event->comment)) !!}
                </div>
                <div class="mt-4 mb-4 row samazon-border-comment">
                    <p>
                        日程&nbsp;：&nbsp;{{$detail['event_date']}}
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{$detail['etime_from']}}〜{{$detail['etime_to']}}
                        <input type="hidden" name="event_date" value="{{ $detail['event_date'] }}"> 
                    </p>
                    <p>
                        会場&nbsp;：&nbsp;{{$detail['venue']}}
                    </p>
                    <p>
                        講師&nbsp;：&nbsp;{{$detail['administrator']}}
                    </p>
                </div>
                <div class="mt-4 mb-4 row samazon-border-comment">
                    <label for="radios" class="col-md-5 col-form-label text-md-left">チケットの選択<span class="ml-1 samazon-label-label"></label>
                    <ul class="radios">
                    <?php $cnt = 1; ?>
                    @foreach($tickets as $ticket)
                        @if ($cnt === 1)
                            @if($ticket->number_seats <= $ticket->number_sales)
                                <li>
                                    <del>{{ $ticket->name }}&nbsp;{{ number_format($ticket->price) }}円（税込）</del>&nbsp;<font class="font-red">完 売</font>
                                </li>
                            @else
                                <li>
                                    <input type="radio" name="ticket" id="ticket-name{{ $ticket->id }}" value="{{ $ticket->price }}" checked>
                                    <label for="ticket-name{{ $ticket->id }}">{{ $ticket->name }}&nbsp;{{ number_format($ticket->price) }}円（税込）</label>
                                    <input type="hidden" name="name{{$ticket->price}}" value="{{ $ticket->name }}"> 
                                </li>
                            @endif
                        @else
                            @if($ticket->number_seats <= $ticket->number_sales)
                                <li>
                                    <del>{{ $ticket->name }}&nbsp;{{ number_format($ticket->price) }}円（税込）</del>&nbsp;<font class="font-red">完 売</font>
                                </li>
                            @else
                                <li>
                                    <input type="radio" name="ticket" id="ticket-name{{ $ticket->id }}" value="{{ $ticket->price }}">
                                    <label for="ticket-name{{ $ticket->id }}">{{ $ticket->name }}&nbsp;{{ number_format($ticket->price) }}円（税込）</label>
                                    <input type="hidden" name="name{{$ticket->price}}" value="{{ $ticket->name }}"> 
                                </li>
                            @endif
                        @endif
                        <?php $cnt++; ?>
                    @endforeach
                    </ul>
                </div>  
                <input type="hidden" name="event_id" value="{{ $event->id }}"> 

                <div class="mt-4 mb-4 row samazon-border-comment">
                    <label for="radios" class="col-md-5 col-form-label text-md-left">お支払い方法<span class="ml-1 samazon-label-label"></label>
                    <ul class="radios">
                        @if ($event->pay_method === 1)
                        <li>
                            <input type="radio" name="pay_method" id="pay_method1" value="1" checked>
                            <label for="pay_method1">クレジット</label>
                        </li>
                        @endif
                        @if ($event->pay_method === 2)
                        <li>
                            <input type="radio" name="pay_method" id="pay_method2" value="2" checked>
                            <label for="pay_method2">銀行振込</label>
                        </li>
                        @endif
                        @if ($event->pay_method === 3)
                        <li>
                            <input type="radio" name="pay_method" id="pay_method1" value="1" checked>
                            <label for="pay_method1">クレジット</label>
                        </li>
                        <li>
                            <input type="radio" name="pay_method" id="pay_method2" value="2">
                            <label for="pay_method2">銀行振込</label>
                        </li>
                        @endif
                    </ul>
                </div>  
 
                <hr />
                <div class="d-flex justify-content-center">
                    <button type="submit" class="w-50 btn samazon-submit-button">次へ（お客様情報入力）</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection