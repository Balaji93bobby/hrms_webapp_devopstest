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
        Schema::create('vmt_emp_attendance_report', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->text('day');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->integer('work_shift_id')->nullable();
            $table->text('checkin_time');
            $table->text('checkin_mode');
            $table->text('checkout_time');
            $table->text('checkout_mode');
            $table->text('lc_minutes');
            $table->text('eg_minutes');
            $table->text('over_time');
            $table->text('status');
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
        Schema::dropIfExists('vmt_emp_attendance_report');
    }
};
