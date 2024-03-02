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
            $table->unsignedBigInteger('department_id')->after('assigner_id');
            $table->foreign('department_id')->references('id')->on('vmt_department');
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
            $table->dropForeign(['department_id']);
            $table->dropColumn('department_id');

        });
    }
};
