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
        Schema::create('vmt_loan_interest_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('vmt_client_master');
            $table->text('loan_applicable_type');
            $table->integer('min_month_served')->nullable();
            $table->text('max_loan_amount')->nullable();
            $table->text('percent_of_ctc')->nullable();
            $table->text('loan_amt_interest');
            $table->integer('deduction_starting_months');
            $table->integer('max_tenure_months');
            $table->text('approver_flow');
            $table->integer('active');
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
        Schema::dropIfExists('vmt_loan_interest_settings');
    }
};
