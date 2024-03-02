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
        Schema::create('vmt_emp_sal_adv_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vmt_emp_assign_salary_adv_id')->constrained('vmt_emp_assign_salary_adv_setting');
            $table->integer('eligible_amount');
            $table->integer('borrowed_amount');
            $table->date('requested_date');
            $table->date('dedction_date');
            $table->text('reason');
            $table->text('approver_flow');
            $table->integer('sal_adv_crd_sts');
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
        Schema::dropIfExists('vmt_emp_sal_adv_details');
    }
};
