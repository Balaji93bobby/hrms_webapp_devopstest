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
            //
            if (Schema::hasColumn('vmt_pms_assignment_v3', 'duedate_goal_settigns')) {
                $table->renameColumn('duedate_goal_settigns','duedate_goal_initiate');
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
        Schema::table('vmt_pms_assignment_v3', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_pms_assignment_v3', 'duedate_goal_initiate')) {
                $table->dropColumn('duedate_goal_initiate');
            }
        });
    }
};
