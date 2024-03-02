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
        Schema::table('vmt_employee_office_details', function (Blueprint $table) {
            $table->integer('hr_user_id')->after('l1_manager_name');
            $table->integer('fa_user__id')->after('hr_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_employee_office_details', function (Blueprint $table) {
            dropColumnIfExists('vmt_employee_office_details',"hr");
            dropColumnIfExists('vmt_employee_office_details',"finance_admin");
        });
    }
};
