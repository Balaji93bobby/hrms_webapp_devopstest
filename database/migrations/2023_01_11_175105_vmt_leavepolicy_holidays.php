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
        Schema::create('vmt_leavepolicy_holidays', function (Blueprint $table) {
            $table->id();
           $table-> text('leavepolicy_id');
           $table->text('holiday_id');
           
        });  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_leavepolicy_holidays', function (Blueprint $table) {
            $table->dropColumn(" ");
            $table->dropColumn("leavepolicy_id");
            $table->dropColumn("holiday_id");
        });
    }
};
