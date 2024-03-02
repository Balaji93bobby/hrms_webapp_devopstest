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
        Schema::table('vmt_employee_attendance_regularizations', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('vmt_employee_attendance_regularizations', 'is_revoked')) {
                $table->integer('is_revoked')->after('status')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_employee_attendance_regularizations', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_employee_attendance_regularizations', 'is_revoked')){
                $table->dropColumn('is_revoked');
            }
        });
    }
};
