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
        Schema::table('vmt_leaves', function (Blueprint $table) {
            $table->text('days_annual')->nullable();
            $table->text('days_monthly')->nullable();
            $table->text('days_restricted')->nullable();
            $table->dropColumn('leave_max_limit');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_leaves', function (Blueprint $table) {
            $table->dropColumn('days_annual');
            $table->dropColumn('days_monthly');
            $table->dropColumn('days_restricted');
            $table->text('leave_max_limit')->nullable();

        });
    }
};
