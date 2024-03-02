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
        Schema::table('vmt_payroll_epf', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_payroll_epf', 'status')) {
                $table->renameColumn('status','is_epf_enabled');
            }
            if (Schema::hasColumn('vmt_payroll_epf', 'is_epf_num_default')) {
                $table->renameColumn('is_epf_num_default','is_epf_policy_default');
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
        Schema::table('vmt_payroll_epf', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_payroll_epf', 'is_epf_enabled')) {
                $table->renameColumn('is_epf_enabled','status');
            }
            if (Schema::hasColumn('vmt_payroll_epf', 'is_epf_policy_default')) {
                $table->renameColumn('is_epf_policy_default','is_epf_num_default');
            }
        });
    }
};
