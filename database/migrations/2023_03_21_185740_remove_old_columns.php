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
        Schema::table('vmt_employee_details', function (Blueprint $table) {

            dropColumnIfExists('vmt_employee_details',"emp_no");
            dropColumnIfExists('vmt_employee_details',"status");
            dropColumnIfExists('vmt_employee_details',"uan");
            dropColumnIfExists('vmt_employee_details',"epf_number");
            dropColumnIfExists('vmt_employee_details',"esic_number");


            dropColumnIfExists('vmt_employee_details',"basic");
            dropColumnIfExists('vmt_employee_details',"hra");
            dropColumnIfExists('vmt_employee_details',"child_edu_allowance");
            dropColumnIfExists('vmt_employee_details',"spl_alw");
            dropColumnIfExists('vmt_employee_details',"total_fixed_gross");
            dropColumnIfExists('vmt_employee_details',"epfemployer");
            dropColumnIfExists('vmt_employee_details',"esicemployer");

            dropColumnIfExists('vmt_employee_details',"ctc");
            dropColumnIfExists('vmt_employee_details',"epfemployee");
            dropColumnIfExists('vmt_employee_details',"esicemployee");
            dropColumnIfExists('vmt_employee_details',"pt");
            dropColumnIfExists('vmt_employee_details',"net");
            dropColumnIfExists('vmt_employee_details',"esic_applicability");


            dropColumnIfExists('vmt_employee_details',"experience_json");
            dropColumnIfExists('vmt_employee_details',"family_info_json");
            dropColumnIfExists('vmt_employee_details',"contact_json");
            dropColumnIfExists('vmt_employee_details',"father_name");
            dropColumnIfExists('vmt_employee_details',"mother_dob");
            dropColumnIfExists('vmt_employee_details',"father_dob");
            dropColumnIfExists('vmt_employee_details',"father_gender");
            dropColumnIfExists('vmt_employee_details',"mother_gender");
            dropColumnIfExists('vmt_employee_details',"father_age");
            dropColumnIfExists('vmt_employee_details',"mother_name");
            dropColumnIfExists('vmt_employee_details',"mother_age");
            dropColumnIfExists('vmt_employee_details',"spouse_name");
            dropColumnIfExists('vmt_employee_details',"spouse_age");
            dropColumnIfExists('vmt_employee_details',"kid_name");
            dropColumnIfExists('vmt_employee_details',"kid_age");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_employee_details', function (Blueprint $table) {
            $table->text("emp_no");
            $table->text("status");
            $table->text("uan");
            $table->text("epf_number");
            $table->text("esic_number");


            $table->text("basic");
            $table->text("hra");
            $table->text("child_edu_allowance");
            $table->text("spl_alw");
            $table->text("total_fixed_gross");
            $table->text("epfemployer");
            $table->text("esicemployer");

            $table->text("ctc");
            $table->text("epfemployee");
            $table->text("esicemployee");
            $table->text("pt");
            $table->text("net");
            $table->text("esic_applicability");


            $table->text("experience_json");
            $table->text("family_info_json");
            $table->text("contact_json");
            $table->text("father_name");
            $table->text("mother_dob");
            $table->text("father_dob");
            $table->text("father_gender");
            $table->text("mother_gender");
            $table->text("father_age");
            $table->text("mother_name");
            $table->text("mother_age");
            $table->text("spouse_name");
            $table->text("spouse_age");
            $table->text("kid_name");
            $table->text("kid_age");
        });
    }
};
