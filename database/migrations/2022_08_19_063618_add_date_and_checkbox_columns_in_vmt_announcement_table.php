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
        Schema::table('vmt_announcement', function (Blueprint $table) {
            $table->date('date')->nullable();
            $table->enum('notify_employees',[0,1])->default(0)->nullable();
            $table->enum('require_acknowledgement',[0,1])->default(0)->nullable();
            $table->enum('hide_after',[0,1])->default(0)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_announcement', function (Blueprint $table) {
            //
        });
    }
};
