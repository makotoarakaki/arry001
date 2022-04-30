@extends('layouts.dashboard')

@section('content')
<h1>イベント売上</h1>
<form method="GET" action="{{ route('dashboard.sellingevents.index')}}" class="form-inline">
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
        <form method="GET" action="{{ route('dashboard.sellingevents.index') }}">
            <div class="d-flex flex-inline form-group">
                <div class="d-flex align-items-center">
                    商品ID・商品名
                </div>
                <textarea id="search-products" name="keyword" class="form-controll ml-2 w-50">{{$keyword}}</textarea>
            </div>
            <button type="submit" class="btn samazon-submit-button">検索</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table fixed-table mt-5">

            <thead>
                <tr>
                    <th scope="col">イベント名</th>
                    <th scope="col">開催日</th>
                    <th scope="col">場所</th>
                    <th scope="col">講師名</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <th scope="row">
                        <a href="/dashboard/sellingevents/{{ $event->id }}?title={{$event->title}}" class="dashboard-edit-link">
                            {{ $event->title }}
                        </a>
                    </th>
                    <td>{{ $event->event_date }}</td>
                    <td>{{ $event->venue }}</td>
                    <td>{{ $event->administrator }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $events->links() }}
</div>
@endsection