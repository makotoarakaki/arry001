<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('billing_type')->default(0);  // 請求タイプ
            $table->string('suppliers')->default(''); // 取引先
            $table->string('contact_tel')->default(''); // 連絡先
            $table->string('contact_name')->default(''); // 連絡先名
            $table->string('contract_no')->default(''); // 請求書番号
            $table->date('date_of_issue')->nullable(); // 発行日
            $table->date('payment_deadline')->nullable(); // お支払期限
            $table->string('katagaki')->default(''); // 肩書き
            $table->string('sender_name')->default(''); // 送付者名
            $table->string('project_title')->default(''); // 案件名
            $table->string('detail')->default(''); // 詳細
            $table->integer('unit_price')->default(0);  // 単価
            $table->integer('quantity')->default(0);  // 数量
            $table->string('unit')->default(''); // 単位
            $table->integer('tax')->default(0);  // 消費税
            $table->text('remarks'); // 備考
            $table->string('payee')->default(''); // 振込先
            $table->text('payee_information'); // 振込先情報
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
        Schema::dropIfExists('contracts');
    }
}
