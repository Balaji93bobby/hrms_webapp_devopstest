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
     if (!Schema::hasTable('vmt_attendance_cycle')) {
        Schema::create('vmt_attendance_cycle', function (Blueprint $table) {
            //
            $table->id();
            $table->integer('client_id');
            $table->date('attendance_cutoff_date');
            $table->integer('is_attcutoff_diff_payenddate');
            $table->integer('is_payperiod_same_att_period');
            $table->date('attendance_start_date');
            $table->date('attendance_end_date');
            $table->integer('paydays_in_month');
            $table->integer('include_weekoffs');
            $table->integer('include_holidays');
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
            Schema::dropIfExists('vmt_attendance_cycle');
    }
};
