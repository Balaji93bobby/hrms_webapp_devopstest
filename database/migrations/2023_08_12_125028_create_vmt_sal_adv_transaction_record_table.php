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
        Schema::create('vmt_sal_adv_transaction_record', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sal_adv_details_id')->constrained('vmt_emp_sal_adv_details');
            $table->text('expected_amt');
            $table->text('paid_amt');
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
        Schema::dropIfExists('vmt_sal_adv_transaction_record');
    }
};
