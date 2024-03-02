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
        if (!Schema::hasTable('vmt_pms_Kpiform_v3'))
        {
            Schema::rename('vmt_pms_Kpiform_v3', 'vmt_pms_kpiform_v3');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('vmt_pms_kpiform_v3'))
        {
            Schema::rename('vmt_pms_kpiform_v3', 'vmt_pms_Kpiform_v3');
        }
    }
};
