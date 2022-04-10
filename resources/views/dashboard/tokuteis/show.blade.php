@extends('layouts.app')

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

    <div style="width:650px; margin:0px auto; text-align:center; background: #ffffff; font-size:12px; line-height:24px;">
        <table bgcolor="#999999" border="1" cellpadding="9" cellspacing="1" style="font-size:13px;text-align:left">
            <tbody>
                <tr>
                    <th bgcolor="#99ccff" width="120px">販売者名</th>
                    <td bgcolor="#FFFFFF">{{ $tokutei->seller }}</td>
                </tr>
                <tr>
                    <th bgcolor="#99ccff" width="120px">運営統括責任者</th>
                    <td bgcolor="#FFFFFF">{{ $tokutei->administrator }}</td>
                </tr>
                <tr>
                    <th bgcolor="#99ccff">電話番号</th>
                    <td bgcolor="#FFFFFF">{{ $tokutei->tel }}</td>
                </tr>
                <tr>
                    <th bgcolor="#99ccff">所在地</th>
                    <td bgcolor="#FFFFFF">{{ $tokutei->address }}</td>
                </tr>
                <tr>
                    <th bgcolor="#99ccff">お問い合わせ先</th>
                    <td bgcolor="#FFFFFF">{{ $tokutei->contact }}</td>
                </tr>
                <tr>
                    <th bgcolor="#99ccff" width="120px">商品の引き渡し時期</th>
                    <td bgcolor="#FFFFFF">{{ $tokutei->delivery_time }}</td>
                </tr>
                <tr>
                    <th bgcolor="#99ccff" width="120px">返品・不良品について</th>
                    <td bgcolor="#FFFFFF">{{ $tokutei->delivery_of_goods }}</td>
                </tr>
                <tr>
                    <th bgcolor="#99ccff" width="120px">表現、及び商品に関する注意書き</th>
                    <td bgcolor="#FFFFFF">{{ $tokutei->caution }}</td>
                </tr>
                <tr>
                    <th bgcolor="#99ccff" width="120px">個人情報の管理について</th>
                    <td bgcolor="#FFFFFF">{{ $tokutei->personal_information }}</td>
                </tr>
                <tr>
                    <th bgcolor="#99ccff" width="120px">商品代金以外の必要料金</th>
                    <td bgcolor="#FFFFFF">{{ $tokutei->required_fee }}</td>
                </tr>
                <tr>
                    <th bgcolor="#99ccff" width="120px">お支払い方法</th>
                    <td bgcolor="#FFFFFF">{{ $tokutei->payment_method }}</td>
                </tr>
                <tr>
                    <th bgcolor="#99ccff" width="120px">代金の支払い時期：クレジット</th>
                    <td bgcolor="#FFFFFF">{{ $tokutei->payment_time_credit }}</td>
                </tr>
                <tr>
                    <th bgcolor="#99ccff" width="120px">代金の支払い時期：銀行振込</th>
                    <td bgcolor="#FFFFFF">{{ $tokutei->payment_time_bank_transfer }}</td>
                </tr>
                <tr>
                    <th bgcolor="#99ccff" width="120px">返品・交換不良品・解約について</th>
                    <td bgcolor="#FFFFFF">{{ $tokutei->cancel }}</td>
                </tr>
            </tbody>
        </table>
    </div>

@endsection