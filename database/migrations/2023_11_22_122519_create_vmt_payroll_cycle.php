<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     if (!Schema::hasTable('vmt_payroll_cycle')) {
        Schema::create('vmt_payroll_cycle', function (Blueprint $table) {
            //
            $table->id();
            $table->integer('client_id');
            $table->integer('pay_frequency_id');
            $table->date('payperiod_start_month');
            $table->date('payperiod_end_date');
            $table->date('payment_date');
            $table->text('currency_type');
            $table->text('remuneration_type');
            $table->timestamps();

        });
     }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            Schema::dropIfExists('vmt_payroll_cycle');
    }
};
