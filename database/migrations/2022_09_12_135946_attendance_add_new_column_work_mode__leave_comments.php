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
            $table->text('work_mode')->default('office');
            $table->text('leave_comments')->nullable();
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
            $table->dropColumn('work_mode');
            $table->dropColumn('leave_comments');
        });
    }
};
