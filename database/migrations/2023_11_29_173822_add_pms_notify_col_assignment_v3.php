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
        Schema::table('vmt_pms_assignment_v3', function (Blueprint $table) {
            $table->text('notif_emp_bfr_duedate')->after('reviewers_flow')->nullable();
            $table->text('notif_emp_for_overduedate')->after('notif_emp_bfr_duedate')->nullable();
            $table->text('notif_mgr_bfr_duedate')->after('notif_emp_for_overduedate')->nullable();
            $table->text('notif_mgr_for_overduedate')->after('notif_mgr_bfr_duedate')->nullable();
        });

        Schema::dropIfExists('vmt_pms_notify_settings_v3');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_pms_assignment_v3', function (Blueprint $table) {
            $table->dropColumn('notif_emp_bfr_duedate');
            $table->dropColumn('notif_emp_for_overduedate');
            $table->dropColumn('notif_mgr_bfr_duedate');
            $table->dropColumn('notif_mgr_for_overduedate');
        });
    }
};
