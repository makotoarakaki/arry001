@extends('layouts.dashboard')

@section('content')
<h1>イベント管理</h1>
<form method="GET" action="{{ route('dashboard.events.index')}}" class="form-inline">
    並び替え
    <select name="sort" onChange="this.form.submit();" class="form-inline ml-2">
        @foreach ($sort as $key => $value)
        @if ($sorted == $value)
        <option value=" {{ $value}}" selected>{{ $key }}</option>
        @else
        <option value=" {{ $value}}">{{ $key }}</option>
        @endif
        @endforeach
    </select>
</form>

<div class="w-75 mt-2">
    <div class="w-75">
        <form method="GET" action="{{ route('dashboard.events.index') }}">
            <div class="d-flex flex-inline form-group">
                <div class="d-flex align-items-center">
                    イベントID・イベント名
                </div>
                <textarea id="search-events" name="keyword" class="form-controll ml-2 w-50">{{$keyword}}</textarea>
            </div>
            <button type="submit" class="btn samazon-submit-button">検索</button>
        </form>
    </div>

    <div class="d-flex justify-content-between w-75 mt-4">
        <h3>合計{{$total_count}}件</h3>

        <a href="{{ route('dashboard.events.create') }}" class="btn samazon-submit-button">+ 新規作成</a>
    </div>
    <div class="table-responsive">
        <table class="table fixed-table mt-5">

            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">画像</th>
                    <th scope="col">イベント名</th>
                    <th scope="col">開催日</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <th scope="row">{{ $event->id }}</th>
                    <td>
                    @if ($event->image !== "")
                        <a href="/dashboard/events/{{ $event->id }}" class="dashboard-edit-link">
                            <img src="{{ asset('public/storage/events/'.$event->image) }}" class="w-80 img-fluid">
                        </a>
                    @else
                        <a href="/dashboard/events/{{ $event->id }}" class="dashboard-edit-link">
                            <img src="{{ asset('img/dummy.png')}}" class="w-80 img-fuild">
                        </a>
                    @endif
                    </td>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->event_date }}</td>
                    <td>
                        <a href="/dashboard/events/{{ $event->id }}/thankyou_email?event_id={{ $event->id }}" class="btn samazon-submit-button">サンキュー<br />メール</a>
                    </td>
                    <td>
                        <a href="/dashboard/events/{{ $event->id }}/edit" class="dashboard-edit-link">編集</a>
                    </td>
                    <td>
                        <a href="/dashboard/events/{{ $event->id }}" onclick="event.preventDefault(); document.getElementById('logout-form{{ $event->id }}').submit();" class="dashboard-delete-link">
                            削除
                        </a>

                        <form id="logout-form{{ $event->id }}" action="/dashboard/events/{{ $event->id }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $events->links() }}
</div>
@endsection