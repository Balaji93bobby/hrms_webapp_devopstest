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
        Schema::create('employee_profile_temp_details', function (Blueprint $table) {

                $table->id();

            if (!Schema::hasColumn('employee_profile_temp_details', 'user_id')) {
                $table->integer('user_id');
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'name')) {
                $table->text('name');
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'gender')) {
                $table->text('gender')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'dob')) {
                $table->date('dob')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'blood_group_id')) {
                $table->integer('blood_group_id')->nullable()->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'father_name')) {
                $table->text('father_name')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'spouse')) {
                $table->integer('spouse')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'doc_type')) {
                $table->integer('doc_type')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'aadhar_number')) {
                $table->integer('aadhar_number')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'aadhar_enrollment_number')) {
                $table->integer('aadhar_enrollment_number')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'aadhar_address')) {
                $table->text('aadhar_address')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'pan_number')) {
                $table->text('pan_number')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'license_number')) {
                $table->text('license_number')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'license_issue_date')) {
                $table->date('license_issue_date')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'license_expires_on')) {
                $table->date('license_expires_on')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'license_address')) {
                $table->date('license_address')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'passport_country_code')) {
                $table->text('passport_country_code')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'passport_type')) {
                $table->text('passport_type')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'passport_number')) {
                $table->text('passport_number')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'passport_date_of_issue')) {
                $table->date('passport_date_of_issue')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'passport_place_of_issue')) {
                $table->text('passport_place_of_issue')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'passport_place_of_birth')) {
                $table->text('passport_place_of_birth')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'passport_expire_on')) {
                $table->date('passport_expire_on')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'voter_id_number')) {
                $table->text('voter_id_number')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'voter_id_issued_on')) {
                $table->date('voter_id_issued_on')->nullable();
            }
            if (!Schema::hasColumn('employee_profile_temp_details', 'voterid_emp_address')) {
                $table->text('voterid_emp_address')->nullable();
            }

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
        Schema::dropIfExists('employee_profile_temp_details');

    }
};
