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
        Schema::create('vmt_work_shifts', function (Blueprint $table) {
            $table->increments('id');
            $table->text('shift_code');
            $table->text('shift_name');
            $table->integer('is_default')->default(0);
            $table->text('shift_timerange_type');
            $table->text('flexible_gross_hours')->nullable();
            $table->time('shift_start_time')->nullable();
            $table->time('shift_end_time')->nullable();
            $table->text('grace_time')->nullable();
            $table->text('week_off_days');
            $table->text('custom_shift_time_for_specific_days')->nullable();
            $table->text('break_timerange_type');
            $table->text('flexible_gross_break')->nullable();
            $table->text('breaktime_morning')->nullable();
            $table->text('breaktime_lunch')->nullable();
            $table->text('breaktime_evening')->nullable();
            $table->text('halfday_min_workhrs')->nullable();
            $table->text('fullday_min_workhrs')->nullable();
            $table->integer('is_lc_applicable')->default(0);
            $table->float('lc_limit_permonth')->nullable();
            $table->float('lc_exceed_lop_day')->nullable();
            $table->integer('is_eg_applicable')->default(0);
            $table->float('eg_limit_permonth')->nullable();
            $table->float('eg_exceed_lop_day')->nullable();
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
        Schema::dropIfExists('vmt_work_shifts');
    }
};
