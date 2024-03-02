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
        Schema::create('vmt_externalapps_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('client_id');
            $table->string('extapp_type_id')->constrained('vmt_externalapps');
            $table->string('access_token');
            $table->string('additional_data')->nullable();
            $table->dateTime('last_token_generated_time')->nullable();
            $table->dateTime('last_token_accessed_time')->nullable();
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
        Schema::dropIfExists('vmt_externalapps_tokens');
    }
};
