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
        Schema::table('vmt_pms_settings_v3', function (Blueprint $table) {
            $table->text('can_assign_upcoming_goals')->after('client_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_pms_settings_v3', function (Blueprint $table) {
            $table->dropColumn('can_assign_upcoming_goals');
        });
    }
};
