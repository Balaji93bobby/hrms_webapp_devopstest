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
        Schema::create('vmt_leavepolicy', function (Blueprint $table) {
            $table->id();
           $table->integer('user_id');
           $table->text('leave_policy_name');
           $table->text('is_active');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_leavepolicy', function (Blueprint $table) {
            $table->dropColumn("");
            $table->dropColumn("user_id");
            $table->dropColumn("leave_policy_name");
            $table->dropColumn("is_active");
        });
    }
};
