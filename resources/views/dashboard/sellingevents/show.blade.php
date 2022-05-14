@extends('layouts.dashboard')

@section('content')
<h1>{{ $title }}</h1>
<div class="w-75">

    <div class="container mt-4">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">コード</th>
                    <th scope="col">年月日</th>
                    <th scope="col">お名前</th>
                    <th scope="col">メールアドレス</th>
                    <th scope="col">チケット</th>
                    <th scope="col">支払方法</th>
                    <th scope="col">金額</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sellings as $selling)
                <tr>
                    <td>{{ $selling['code'] }}</td>
                    <td>{{ $selling['event_date'] }}</td>
                    <td>{{ $selling['user_name'] }}</td>
                    <td>{{ $selling['email'] }}</td>
                    <td>{{ $selling['ticket_name'] }}</td>
                    <td>{{ $selling['pay_method'] }}</td>
                    <td>{{ number_format($selling['price']) }}</td>
                </tr>
                @endforeach
                <tr>
                    <th>合計</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="right"><b>{{ $total }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
 
</div>
@endsection