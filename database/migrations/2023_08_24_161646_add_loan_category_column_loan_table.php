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
        Schema::table('vmt_emp_int_loan_details', function (Blueprint $table) {
            $table->text('loan_category')->nullable()->after('paid_date');
        });

        Schema::table('vmt_emp_int_free_loan_details', function (Blueprint $table) {
            $table->text('loan_category')->nullable()->after('paid_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        dropColumnIfExists('vmt_emp_int_loan_details','loan_category');
        dropColumnIfExists('vmt_emp_int_free_loan_details','loan_category');
    }
};
