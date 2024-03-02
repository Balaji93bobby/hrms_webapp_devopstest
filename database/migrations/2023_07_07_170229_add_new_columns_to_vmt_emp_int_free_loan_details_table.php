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
        Schema::table('vmt_emp_int_free_loan_details', function (Blueprint $table) {
            $table->text('loan_status')->after('loan_crd_sts');
            $table->text('reviewer_cmds')->nullable()->after('loan_status');
            $table->date('paid_date')->nullable()->after('reviewer_cmds');
            $table->text('UTR_number')->nullable()->after('paid_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        dropColumnIfExists("vmt_emp_int_free_loan_details",'loan_status');
        dropColumnIfExists("vmt_emp_int_free_loan_details",'reviewer_cmds');
        dropColumnIfExists("vmt_emp_int_free_loan_details",'paid_date');
        dropColumnIfExists("vmt_emp_int_free_loan_details",'UTR_number');
    }
};
