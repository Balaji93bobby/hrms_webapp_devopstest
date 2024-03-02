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
        Schema::table('vmt_pms_assignment_settings_v3', function (Blueprint $table) {
            $table->integer('vmt_org_time_period_id')->after('client_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_pms_assignment_settings_v3', function (Blueprint $table) {
            $table->dropColumn('vmt_org_time_period_id');
        });
    }
};
