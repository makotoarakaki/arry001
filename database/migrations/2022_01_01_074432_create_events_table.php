<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('comment');
            $table->string('image')->default('');
            $table->integer('category_id')->unsigned();
            $table->date('event_date')->nullable(); // 開催日
            $table->time('event_time_from')->nullable(); // 開催時間開始
            $table->time('event_time_to')->nullable();// 開催時間終了
            $table->text('venue');// 会場
            $table->string('administrator');// 運営者
            $table->integer('pay_method')->default(0);  // 0:なし 1:クレジット 2:銀行振込 4:両方
            $table->string('ntc_email')->nullable();
            $table->string('ntc_email2')->nullable();
            $table->string('ntc_email3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
