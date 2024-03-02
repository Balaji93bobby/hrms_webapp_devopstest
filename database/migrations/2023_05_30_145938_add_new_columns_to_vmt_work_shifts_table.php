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
            $table->integer('is_auto_checkout')->default(0);
            $table->text('ac_time_interval')->nullable();
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
            $table->dropColumn('is_auto_checkout');
            $table->dropColumn('ac_time_interval');
        });
    }
};
