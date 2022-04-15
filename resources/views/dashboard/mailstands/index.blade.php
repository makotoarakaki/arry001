@extends('layouts.dashboard')

@section('content')
<h1>メール管理</h1>
<form method="GET" action="{{ route('dashboard.mailstands.index')}}" class="form-inline">
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
        <form method="GET" action="{{ route('dashboard.mailstands.index') }}">
            <div class="d-flex flex-inline form-group">
                <div class="d-flex align-items-center">
                    メールID・タイトル
                </div>
                <textarea id="search-events" name="keyword" class="form-controll ml-2 w-50">{{$keyword}}</textarea>
            </div>
            <button type="submit" class="btn samazon-submit-button">検索</button>
        </form>
    </div>

    <div class="d-flex justify-content-between w-75 mt-4">
        <h3>合計{{$total_count}}件</h3>
        
        <a href="{{ route('dashboard.mailstands.create') }}" class="btn samazon-submit-button">+ 新規作成</a>
    </div>
    <div class="table-responsive">
        <table class="table fixed-table mt-5">

            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">タイトル</th>
                    <th scope="col">配信日</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($mails as $mail)
                <tr>
                    <th scope="row">{{ $mail->id }}</td>
                    <td>{{ $mail->title }}</td>
                    <td>{{ $mail->send_datetime }}</td>
                    <td>
                        <a href="/dashboard/mailstands/{{ $mail->id }}/edit" class="dashboard-edit-link">編集</a>
                    </td>
                    <td>
                        <a href="/dashboard/mailstands/{{ $mail->id }}" onclick="event.preventDefault(); document.getElementById('logout-form{{ $mail->id }}').submit();" class="dashboard-delete-link">
                            削除
                        </a>
                        <form id="logout-form{{ $mail->id }}" action="/dashboard/mailstands/{{ $mail->id }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $mails->links() }}
</div>
@endsection