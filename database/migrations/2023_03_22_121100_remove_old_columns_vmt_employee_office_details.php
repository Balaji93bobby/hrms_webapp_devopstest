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

            dropColumnIfExists('vmt_employee_office_details',"emp_id");
            dropColumnIfExists('vmt_employee_office_details',"l2_manager_code");
            dropColumnIfExists('vmt_employee_office_details',"l2_manager_designation");
            dropColumnIfExists('vmt_employee_office_details',"l2_manager_name");
            dropColumnIfExists('vmt_employee_office_details',"l3_manager_code");
            dropColumnIfExists('vmt_employee_office_details',"l3_manager_designation");
            dropColumnIfExists('vmt_employee_office_details',"l3_manager_name");
            dropColumnIfExists('vmt_employee_office_details',"l4_manager_code");
            dropColumnIfExists('vmt_employee_office_details',"l4_manager_designation");
            dropColumnIfExists('vmt_employee_office_details',"l4_manager_name");
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
            $table->text("emp_id");
            $table->text("l2_manager_code");
            $table->text("l2_manager_designation");
            $table->text("l2_manager_name");
            $table->text("l3_manager_code");
            $table->text("l3_manager_designation");
            $table->text("l3_manager_name");
            $table->text("l4_manager_code");
            $table->text("l4_manager_designation");
            $table->text("l4_manager_name");
        });
    }
};
