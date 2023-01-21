@extends('layouts.dashboard')

@section('content')
<h1>請求書管理</h1>
<form method="GET" action="{{ route('dashboard.contracts.index')}}" class="form-inline">
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
        <form method="GET" action="{{ route('dashboard.contracts.index') }}">
            <div class="d-flex flex-inline form-group">
                <div class="d-flex align-items-center">
                    請求書ID・タイトル
                </div>
                <textarea id="search-events" name="keyword" class="form-controll ml-2 w-50">{{$keyword}}</textarea>
            </div>
            <button type="submit" class="btn samazon-submit-button">検索</button>
        </form>
    </div>

    <div class="d-flex justify-content-between w-75 mt-4">
        <h3>合計{{$total_count}}件</h3>
        
        <a href="{{ route('dashboard.contracts.create') }}" class="btn samazon-submit-button">+ 新規作成</a>
    </div>
    <div class="table-responsive">
        <table class="table fixed-table mt-5">

            <thead>
                <tr>
                    <th scope="col">取引先</th>
                    <th scope="col">案件名</th>
                    <th scope="col">合計金額</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($contracts as $contract)
                <tr>
                    <th scope="row">{{ $contract->suppliers }}</td>
                    <td>{{ $contract->project_title }}</td>
                    <td>{{ $contract->total_amount }}</td>
                    <td>
                        <a href="/dashboard/contracts/{{ $contract->id }}/edit" class="dashboard-edit-link">編集</a>
                    </td>
                    <td>
                        <a href="/dashboard/contracts/{{ $contract->id }}" onclick="event.preventDefault(); document.getElementById('logout-form{{ $contract->id }}').submit();" class="dashboard-delete-link">
                            削除
                        </a>
                        <form id="logout-form{{ $contract->id }}" action="/dashboard/contracts/{{ $contract->id }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $contracts->links() }}
</div>
@endsection