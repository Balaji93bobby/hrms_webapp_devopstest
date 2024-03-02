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
        Schema::create('vmt_int_free_loan_transaction_record', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emp_loan_details_id')->constrained('vmt_emp_int_free_loan_details');
            $table->text('expected_emi');
            $table->text('paid_emi')->default(0);
            $table->date('payroll_date');
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
        Schema::dropIfExists('vmt_int_free_loan_transaction_record');
    }
};
