@extends('layouts.dashboard')

@section('content')
<div class="w-50">
    <h1>サンキューメール作成</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <hr>

    <form method="POST" action="/dashboard/events/{{ $event->id }}/compose_email" class="mb-5" enctype="multipart/form-data">
        {{ csrf_field() }}
       <div class="form-inline mt-4 mb-4 row">
            <label for="mail-title" class="col-2 d-flex justify-content-start">件名<span class="ml-1 samazon-require-input-label"><span class="samazon-require-input-label-text">必須</span></span></label></label>
            <input type="text" name="mail_title" id="mail-title" class="form-control col-8" value="{{ $event->mail_title }}">
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="mail-content" class="col-2 d-flex justify-content-start align-self-start">本文<span class="ml-1 samazon-require-input-label"><span class="samazon-require-input-label-text">必須</span></span></label></label>
            <textarea name="mail_content" id="mail-content" class="form-control col-8" rows="10">{{ $event->mail_content }}</textarea>
        </div>
        <input type="hidden" name="id" value="{{ $event->id }}">
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn samazon-submit-button">更新する</button>
        </div>
    </form>

    <div class="d-flex justify-content-end">
        <a href="/dashboard/events">イベント一覧に戻る</a>
    </div>
</div>

@endsection