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
            $table->integer('flow_type')->after('vmt_pms_assignment_v3_id');
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
            $table->dropColumn('flow_type');
        });
    }
};
