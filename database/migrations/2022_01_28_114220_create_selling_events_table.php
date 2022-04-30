<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellingEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selling_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->default("");
            $table->integer('price')->default(0);
            $table->string('ticket_name')->default("");
            $table->integer('user_id');
            $table->integer('event_id');
            $table->integer('pay_method')->default(0);
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
        Schema::dropIfExists('selling_events');
    }
}
