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
            //
            if (!Schema::hasColumn('vmt_employee_details', 'dl_issue_date')) {
                $table->text('dl_issue_date')->nullable()->after('dl_no');
            }
            if (!Schema::hasColumn('vmt_employee_details', 'dl_expire_on')) {
                $table->text('dl_expire_on')->nullable()->after('dl_issue_date');
            }
            if (!Schema::hasColumn('vmt_employee_details', 'dl_emp_address')) {
                $table->text('dl_emp_address')->nullable()->after('dl_expire_on');
            }
            if (!Schema::hasColumn('vmt_employee_details', 'voterid_emp_address')) {
                $table->text('voterid_emp_address')->nullable()->after('voter_id_issued_on');
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
        Schema::table('vmt_employee_details', function (Blueprint $table) {
            //

            if (Schema::hasColumn('vmt_employee_details', 'dl_issue_date')) {
                $table->dropColumn('dl_issue_date');
            }
            if (Schema::hasColumn('vmt_employee_details', 'dl_expire_on')) {
                $table->dropColumn('dl_expire_on');
            }
            if (Schema::hasColumn('vmt_employee_details', 'dl_emp_address')) {
                $table->dropColumn('dl_emp_address');
            }
            if (Schema::hasColumn('vmt_employee_details', 'voterid_emp_address')) {
                $table->dropColumn('voterid_emp_address');
            }
        });
    }
};
