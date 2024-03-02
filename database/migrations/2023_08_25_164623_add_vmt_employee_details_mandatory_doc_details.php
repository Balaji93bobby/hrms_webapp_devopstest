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
        Schema::table('vmt_employee_details', function(Blueprint $table) {
            $table->text('aadhar_enrollment_number')->nullable();
            $table->text('voter_id')->nullable();
            $table->text('voter_id_issued_on')->nullable();
            $table->text('degree')->nullable();
            $table->text('branch_specialization')->nullable();
            $table->text('year_of_completed')->nullable();
            $table->text('cgpa_percentage')->nullable();
            $table->text('university_school')->nullable();
            $table->text('country_code')->nullable();
            $table->text('passport_type')->nullable();
            $table->text('date_of_issue')->nullable();
            $table->text('place_of_issue')->nullable();
            $table->text('place_of_birth')->nullable();
            $table->text('exepire_on')->nullable();

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

            $table->dropColumn('aadhar_enrollment_number');
            $table->dropColumn('voter_id');
            $table->dropColumn('voter_id_issued_on');
            $table->dropColumn('degree');
            $table->dropColumn('branch_specialization');
            $table->dropColumn('year_of_completed');
            $table->dropColumn('cgpa_percentage');
            $table->dropColumn('university_school');
            $table->dropColumn('country_code');
            $table->dropColumn('passport_type');
            $table->dropColumn('date_of_issue');
            $table->dropColumn('place_of_issue');
            $table->dropColumn('place_of_birth');
            $table->dropColumn('exepire_on');

        });
    }
};
