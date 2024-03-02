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
        Schema::table('vmt_pms_kpiform_assigned_v3', function ($table) {
            $table->unsignedBigInteger('vmt_pms_assignment_v3_id')->after('assigner_id');
            $table->foreign('vmt_pms_assignment_v3_id')->references('id')->on('vmt_pms_assignment_v3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_pms_kpiform_assigned_v3', function ($table) {
            $table->dropForeign(['vmt_pms_assignment_v3_id']);
            $table->dropColumn('vmt_pms_assignment_v3_id');
        });
    }
};
