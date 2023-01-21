@extends('layouts.dashboard')

@section('content')

<div>
    <h1>請求書作成</h1>
    @if (isset($error))
        <div class="alert alert-danger">
            <ul>
                <li>{{ $error }}</li>
            </ul>
        </div>
    @endif
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

    <form method="POST" action="/dashboard/contracts" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-inline mt-4 mb-4 row">
            <label for="ticket-tax" class="col-2 d-flex justify-content-start align-self-start">請求パターン</label>
            <ul class="radios">
                <li>
                    <div class="input-group">
                        <input type="radio" class="js-check" name="billing_type" id="billing_type-1" value="1" checked>
                        <label for="billing_type-1">１回請求</label>
                    </div>
                </li>
                <li>
                    <div class="input-group">
                        <input type="radio" class="js-check" name="billing_type" id="billing_type-2" value="2">
                        <label for="billing_type-2">毎月請求（サブスク）</label>
                    </div>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-6">
            <label for="atesaki" class="col-6 contracts-headline">宛先</label>
                <p>
                    <div class="form-inline row">
                            <label for="contracts-suppliers" class="col-2 d-flex justify-content-start">取引先</label>
                            <input type="text" name="suppliers" id="contracts-suppliers" class="col-4 form-control" required>
                    </div>
                </p>
                <p>
                    <div class="form-inline row">
                        <label for="contracts-contact_tel" class="col-2 d-flex justify-content-start">連絡先</label>
                        <input type="text" name="contact_tel" id="contracts-contact_tel" class="col-4 form-control">
                    </div>
                </p>
                <p>
                    <div class="form-inline row">
                        <label for="contracts-contact_name" class="col-2 d-flex justify-content-start">連絡名</label>
                        <input type="text" name="contact_name" id="contracts-contact_name" class="col-4 form-control">
                    </div>
                </p>
            </div>
            <div class="col-6">
            <label for="syorui" class="col-6 contracts-headline">書類</label>
                <p>
                    <div class="form-inline row">
                        <label for="contracts-contract_no" class="col-2 d-flex justify-content-start">請求書番号</label>
                        <input type="text" name="contract_no" id="contracts-contract_no" class="col-4 form-control" required>
                </div>
                </p>
                <p>
                    <div class="form-inline row">
                        <label for="contracts-date_of_issue" class="col-2 d-flex justify-content-start">発行日</label>
                        <div class="input-group date" id="datePicker1" data-target-input="nearest">                                                        
                            <input type="datetime" name="date_of_issue" class="form-control form-control-sm datetimepicker-input" data-target="#datePicker"/>
                            <div class="input-group-append" data-target="#datePicker1" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </p>
                <p>
                    <div class="form-inline row">
                        <label for="contracts-payment_deadline" class="col-2 d-flex justify-content-start">お支払期限</label>
                        <div class="input-group date" id="datePicker2" data-target-input="nearest">                                                        
                            <input type="datetime" name="payment_deadline" class="form-control form-control-sm datetimepicker-input" data-target="#datePicker"/>
                            <div class="input-group-append" data-target="#datePicker2" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </p>
            </div>
        </div>        
        <div class="form-inline mt-4 mb-4 row">
            <label for="mail-title" class="col-2 d-flex justify-content-start">タイトル</label>
            <input type="text" name="title" id="mail-title" class="form-control col-8" required>
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="mail-comment" class="col-2 d-flex justify-content-start align-self-start">メール本文</label>
            <textarea name="comment" id="mail-comment" class="form-control col-8" rows="10" required></textarea>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="w-25 btn samazon-submit-button loadbtn">保存</button>
        </div>
    </form>

    <div class="d-flex justify-content-end">
        <a href="/dashboard/contracts">請求書一覧に戻る</a>
    </div>
</div>

    <!-- datepicker -->
    <!-- Tempus Dominus Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js" integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/locale/ja.min.js" integrity="sha512-rElveAU5iG1CzHqi7KbG1T4DQIUCqhitISZ9nqJ2Z4TP0z4Aba64xYhwcBhHQMddRq27/OKbzEFZLOJarNStLg==" crossorigin="anonymous"></script>
    <!-- Moment.js -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0/js/tempusdominus-bootstrap-4.min.js"></script>

<script type="text/javascript">
    $(function(){
        $('#datePicker1').datetimepicker({locale: 'ja', dayViewHeaderFormat: 'YYYY年M月' ,format: 'YYYY/MM/DD'});
    });
    $(function(){
        $('#datePicker2').datetimepicker({locale: 'ja', dayViewHeaderFormat: 'YYYY年M月' ,format: 'YYYY/MM/DD'});
    });

</script>
@endsection