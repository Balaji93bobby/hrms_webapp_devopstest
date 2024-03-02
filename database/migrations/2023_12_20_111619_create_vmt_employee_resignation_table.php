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
        Schema::create('vmt_employee_resignation', function (Blueprint $table) {
            $table->id();
            $table->date('request_date');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vmt_resignation_type_id');
            $table->text('resignation_reason')->nullable();
            $table->date('notice_period_date');
            $table->date('expected_last_working_day');
            $table->date('last_payroll_date');
            $table->text('reason_for_dol_change')->nullable();
            $table->text('approval_status');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('vmt_resignation_type_id')->references('id')->on('vmt_resignation_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vmt_employee_resignation');
    }
};
