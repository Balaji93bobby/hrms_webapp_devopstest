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
        Schema::table('vmt_employee_details', function (Blueprint $table){
            // voter id
            if (Schema::hasColumn('vmt_employee_details', 'voter_id')) {
                $table->renameColumn("voter_id", "voter_id_number");
            }


            if (Schema::hasColumn('vmt_employee_details', 'branch_specialization')) {
                $table->renameColumn("branch_specialization", "dc_branch_specialization");
            }

            if (Schema::hasColumn('vmt_employee_details', 'year_of_completed')) {
                $table->renameColumn("year_of_completed", "dc_year_of_completion");
            }
            if (Schema::hasColumn('vmt_employee_details', 'cgpa_percentage')) {
                $table->renameColumn("cgpa_percentage", "dc_cgpa_percentage");
            }
            if (Schema::hasColumn('vmt_employee_details', 'university_school')) {
                $table->renameColumn("university_school", "dc_university_school");
            }
            // passport

            if (Schema::hasColumn('vmt_employee_details', 'country_code')) {
                $table->renameColumn("country_code", "passport_country_code");
            }
            if (Schema::hasColumn('vmt_employee_details', 'date_of_issue')) {
                $table->renameColumn("date_of_issue", "passport_date_of_issue");
            }
            if (Schema::hasColumn('vmt_employee_details', 'place_of_issue')) {
                $table->renameColumn("place_of_issue", "passport_place_of_issue");
            }
            if (Schema::hasColumn('vmt_employee_details', 'place_of_birth')) {
                $table->renameColumn("place_of_birth", "passport_place_of_birth");
            }
            if (Schema::hasColumn('vmt_employee_details', 'exepire_on')) {
                $table->renameColumn("exepire_on", "passport_expire_on");
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
        Schema::table('vmt_payroll_components', function (Blueprint $table) {

            if (Schema::hasColumn('vmt_employee_details', 'voter_id_number')) {
                $table->dropColumn('voter_id_number');
            }
            if (Schema::hasColumn('vmt_employee_details', 'dc_branch_specialization')) {
                $table->dropColumn('dc_branch_specialization');
            }
            if (Schema::hasColumn('vmt_employee_details', 'dc_year_of_completion')) {
                $table->dropColumn('dc_year_of_completion');
            }
            if (Schema::hasColumn('vmt_employee_details', 'dc_cgpa_percentage')) {
                $table->dropColumn('dc_cgpa_percentage');
            }
            if (Schema::hasColumn('vmt_employee_details', 'dc_university_school')) {
                $table->dropColumn('dc_university_school');
            }
            if (Schema::hasColumn('vmt_employee_details', 'passport_country_code')) {
                $table->dropColumn('passport_country_code');
            }
            if (Schema::hasColumn('vmt_employee_details', 'passport_date_of_issue')) {
                $table->dropColumn('passport_date_of_issue');
            }
            if (Schema::hasColumn('vmt_employee_details', 'passport_place_of_issue')) {
                $table->dropColumn('passport_place_of_issue');
            }

            if (Schema::hasColumn('vmt_employee_details', 'passport_place_of_birth')) {
                $table->dropColumn('passport_place_of_birth');
            }
            if (Schema::hasColumn('vmt_employee_details', 'passport_expire_on')) {
                $table->dropColumn('passport_expire_on');
            }


    });
}
};
