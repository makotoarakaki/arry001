@extends('layouts.dashboard')

@section('content')
<div class="w-50">
    <h1>チケット作成</h1>

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

    <form method="POST" name="form1" action="/dashboard/tickets/{{ $ticket->id }}edit?event_id={{$ticket->event_id}}" class="mb-5" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <div class="form-inline mt-4 mb-4 row">
            <label for="ticket-name" class="col-2 d-flex justify-content-start">チケット名</label>
            <input type="text" name="name" id="ticket-name" class="form-control col-8" value="{{ $ticket->name }}">
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="ticket-amount" class="col-2 d-flex justify-content-start align-self-start">金額</label>
            <input type="number" name="price" id="ticket-amount" class="form-control col-8 taxExcluded" value="{{ $ticket->price }}">&nbsp;円
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="ticket-amount" class="col-2 d-flex justify-content-start align-self-start"></label>
            <span class="automaticCalculation"></span>
        </div>
        <div class="form-inline mt-4 mb-4 row">
            <label for="ticket-sheets" class="col-2 d-flex justify-content-start align-self-start">販売数</label>
            <input type="number" name="number_seats" id="ticket-sheets" class="form-control col-8" value="{{ $ticket->number_seats }}">
        </div>

        <div class="form-inline mt-4 mb-4 row">
            <label for="ticket-tax" class="col-2 d-flex justify-content-start align-self-start">消費税</label>
            <ul class="radios">
                <li>
                    <input type="radio" name="tax_flg" class="taxChoise" id="ticket-tax_flg1" value="1" {{ $ticket->tax_flg == 1 ? 'checked' : '' }}>
                    <label for="ticket-tax_flg1">税込価格</label>
                </li>
                <li>
                    <input type="radio" name="tax_flg" class="taxChoise" id="ticket-tax_flg2" value="2" {{ $ticket->tax_flg == 2 ? 'checked' : '' }}> 
                    <label for="ticket-tax_flg2">税別価格</label>
                </li>
            </ul>
        </div>
        <input type="hidden" value="{{}}">
        <div class="d-flex justify-content-end">
            <button type="submit" class="w-50 btn samazon-submit-button">更新する</button>
        </div>
    </form>

    <div class="d-flex justify-content-end">
        <a href="/dashboard/events">イベント一覧に戻る</a>
    </div>
</div>

 <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <script>

  //税込を入力、税抜は自動計算
  //＜body＞要素をon()を使ってchange()発動
  $(function(){
    $('body').on('change', '.taxExcluded', function() {
      const TAX = 110;

      var elem = document.getElementById('ticket-tax_flg2');

      if (elem.checked){    
        $(this).parent().parent().find('.automaticCalculation').text('（ 税込 ' + Math.round(parseInt($(this).val()) * TAX / 100).toLocaleString() +  '円 ）');
      } else {
        $(this).parent().parent().find('.automaticCalculation').text('（ 内消費税 ' + Math.round(parseInt($(this).val()) / (1 + TAX) * 10).toLocaleString() +  '円 ）');
      }
    });
  });

  $(function(){
    $('body').on('click', '.taxChoise', function() {
      const TAX = 110;

      var elem = document.getElementById('ticket-tax_flg2');
      if (elem.checked){    
          $(this).parent().parent().find('.automaticCalculation').text('（ 税込 ' + Math.round(parseInt($(this).val()) * TAX / 100).toLocaleString() +  '円 ）');
      } else {
        $(this).parent().parent().find('.automaticCalculation').text('（ 内消費税 ' + Math.round(parseInt($(this).val()) / (1 + TAX) * 10).toLocaleString() +  '円 ）');
      }
    });
  });
  </script>

@endsection