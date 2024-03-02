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
        Schema::table('vmt_work_shifts', function (Blueprint $table) {
            $table->integer('consider_mip_mop_as_absent')->default(0)->after('eg_exceed_lop_day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_work_shifts', function (Blueprint $table) {
            $table->dropColumn('consider_mip_mop_as_absent');
        });
    }
};
