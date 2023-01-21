<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecurringToTokuteisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tokuteis', function (Blueprint $table) {
            $table->text('recurring_method')->default(null); // 定期課金：支払い方法
            $table->string('recurring_time_credit')->default(null); // 定期課金：代金の支払い時期：クレジット
            $table->string('recurring_time_bank_transfer')->default(null); // 定期課金：代金の支払い時期：銀行振込
            $table->text('recurring_midterm_cancel')->default(null); // 定期課金途中解約
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tokuteis', function (Blueprint $table) {
            //
        });
    }
}
