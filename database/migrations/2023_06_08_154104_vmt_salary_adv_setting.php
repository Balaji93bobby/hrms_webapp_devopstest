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
        Schema::create('vmt_salary_adv_setting', function (Blueprint $table) {
            $table->id();
            $table->integer('percent_salary_adv');
            $table->integer('deduction_period_of_months');
            $table->text('approver_flow');
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
        Schema::dropIfExists('vmt_salary_adv_setting');
    }
};
