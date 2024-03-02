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
        Schema::table('vmt_emp_sal_adv_details', function (Blueprint $table) {
            $table->text('request_id')->after('vmt_emp_assign_salary_adv_id');
        });
        Schema::table('vmt_emp_int_loan_details', function (Blueprint $table) {
            $table->text('request_id')->after('vmt_int_loan_id');
        });
        Schema::table('vmt_emp_int_free_loan_details', function (Blueprint $table) {
            $table->text('request_id')->after('vmt_int_free_loan_id');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        dropColumnIfExists("vmt_emp_sal_adv_details",'request_id');
        dropColumnIfExists("vmt_emp_int_loan_details",'request_id');
        dropColumnIfExists("vmt_emp_int_free_loan_details",'request_id');
    }
};
