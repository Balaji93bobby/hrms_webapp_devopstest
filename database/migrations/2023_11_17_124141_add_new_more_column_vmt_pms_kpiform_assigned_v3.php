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
        Schema::table('vmt_pms_kpiform_assigned_v3', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('vmt_pms_kpiform_assigned_v3', 'goal_initiated_date')) {
                $table->date('goal_initiated_date')->nullable()->after('assigner_id');
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
        Schema::table('vmt_pms_kpiform_assigned_v3', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_pms_kpiform_assigned_v3', 'goal_initiated_date')) {
                $table->dropColumn('goal_initiated_date');
            }
        });
    }
};
