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
        Schema::table('vmt_employee_attendance', function (Blueprint $table) {
            $table->renameColumn("attendance_mode","attendance_mode_checkin");
            $table->text("attendance_mode_checkout");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_employee_attendance', function (Blueprint $table) {
            $table->renameColumn("attendance_mode_checkin","attendance_mode");
            $table->dropColumn("attendance_mode_checkout");

        });
    }
};
