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
        Schema::create('vmt_client_empcode', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Client_id')->constrained('vmt_client_master');
            $table->text('empcode_prefix');
            $table->text('empcode_suffix');
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
        Schema::dropIfExists('vmt_client_empcode');
    }
};
