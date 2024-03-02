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
        Schema::create('vmt_work_shifts', function (Blueprint $table) {
            $table->id();
            $table->text('shift_type')->nullable();
            $table->timestamp('shift_start_time')->nullable();
            $table->timestamp('shift_end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vmt_work_shifts');
    }
};
