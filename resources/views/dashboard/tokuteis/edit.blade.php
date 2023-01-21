@extends('layouts.dashboard')

@section('content')
<div class="w-50">
    <h1>【特定商取引法に基づく表記】</h1>

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

    <form method="POST" action="/dashboard/tokuteis/{{ $tokutei->id }}" class="mb-5" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <div class="form-inline mt-4 mb-4 row">
            <label for="tokutei-seller" class="col-2 d-flex justify-content-start">販売者名</label>
            <input type="text" name="seller" id="tokutei-seller" class="form-control col-8" value="{{ $tokutei->seller }}">
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="tokutei-administrator" class="col-2 d-flex justify-content-start">運営統括責任者</label>
            <input type="text" name="administrator" id="tokutei-administrator" class="form-control col-8" value="{{ $tokutei->administrator }}">
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="tokutei-tel" class="col-2 d-flex justify-content-start">電話番号</label>
            <input type="text" name="tel" id="tokutei-tel" class="form-control col-8" value="{{ $tokutei->tel }}">
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="tokutei-address" class="col-2 d-flex justify-content-start">所在地</label>
            <input type="text" name="address" id="tokutei-address" class="form-control col-8" value="{{ $tokutei->address }}">
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="tokutei-contact" class="col-2 d-flex justify-content-start">お問い合わせ先</label>
            <input type="text" name="contact" id="tokutei-contact" class="form-control col-8" value="{{ $tokutei->contact }}">
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="tokutei-delivery_time" class="col-2 d-flex justify-content-start align-self-start">商品の引き渡し時期</label>
            <textarea name="delivery_time" id="tokutei-delivery_time" class="form-control col-8" rows="3">{{ $tokutei->delivery_time }}</textarea>
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="tokutei-delivery_of_goods" class="col-2 d-flex justify-content-start align-self-start">返品・不良品について</label>
            <textarea name="delivery_of_goods" id="tokutei-delivery_of_goods" class="form-control col-8" rows="3">{{ $tokutei->delivery_of_goods }}</textarea>
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="tokutei-caution" class="col-2 d-flex justify-content-start align-self-start">表現、及び商品に関する注意書き</label>
            <textarea name="caution" id="tokutei-caution" class="form-control col-8" rows="3">{{ $tokutei->caution }}</textarea>
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="tokutei-personal_information" class="col-2 d-flex justify-content-start align-self-start">個人情報の管理について</label>
            <textarea name="personal_information" id="tokutei-personal_information" class="form-control col-8" rows="3">{{ $tokutei->personal_information }}</textarea>
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="tokutei-required_fee" class="col-2 d-flex justify-content-start">商品代金以外の必要料金 </label>
            <input type="text" name="required_fee" id="tokutei-required_fee" class="form-control col-8" value="{{ $tokutei->required_fee }}">
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="tokutei-payment" class="col-12 d-flex">都度課金</label>
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="tokutei-payment_method" class="col-2 d-flex justify-content-start align-self-start">お支払い方法</label>
            <textarea name="payment_method" id="tokutei-payment_method" class="form-control col-8" rows="3">{{ $tokutei->payment_method }}</textarea>
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="tokutei-payment_time_credit" class="col-2 d-flex justify-content-start">代金の支払い時期：クレジット </label>
            <input type="text" name="payment_time_credit" id="tokutei-payment_time_credit" class="form-control col-8" value="{{ $tokutei->payment_time_credit }}">
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="tokutei-payment_time_bank_transfer" class="col-2 d-flex justify-content-start">代金の支払い時期：銀行振込 </label>
            <input type="text" name="payment_time_bank_transfer" id="tokutei-payment_time_bank_transfer" class="form-control col-8" value="{{ $tokutei->payment_time_bank_transfer }}">
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="tokutei-cancel" class="col-2 d-flex justify-content-start align-self-start">返品・交換不良品・解約について</label>
            <textarea name="cancel" id="tokutei-cancel" class="form-control col-8" rows="3">{{ $tokutei->cancel }}</textarea>
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="recurring-tokutei-payment" class="col-12 d-flex">定期課金</label>
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="recurring_method" class="col-2 d-flex justify-content-start align-self-start">お支払い方法</label>
            <textarea name="recurring_method" id="recurring_method" class="form-control col-8" rows="3">{{ $tokutei->recurring_method }}</textarea>
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="recurring_time_credit" class="col-2 d-flex justify-content-start">代金の支払い時期：クレジット </label>
            <input type="text" name="recurring_time_credit" id="recurring_time_credit" class="form-control col-8" value="{{ $tokutei->recurring_time_credit }}">
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="recurring_time_bank_transfer" class="col-2 d-flex justify-content-start">代金の支払い時期：銀行振込 </label>
            <input type="text" name="recurring_time_bank_transfer" id="recurring_time_bank_transfer" class="form-control col-8" value="{{ $tokutei->recurring_time_bank_transfer }}">
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="recurring_midterm_cancel" class="col-2 d-flex justify-content-start align-self-start">返品・交換不良品・解約について</label>
            <textarea name="recurring_midterm_cancel" id="recurring_midterm_cancel" class="form-control col-8" rows="3">{{ $tokutei->recurring_midterm_cancel }}</textarea>
        </div>
       <div class="d-flex justify-content-end">
            <button type="submit" class="w-25 btn samazon-submit-button">更新</button>
        </div>
    </form>

    <div class="d-flex justify-content-end">
        <a href="/dashboard/products">商品一覧に戻る</a>
    </div>
</div>

@endsection