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
        Schema::create('vmt_paygroup', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->text('paygroup_name');
            $table->text('description');
            $table->integer('pf');
            $table->integer('esi');
            $table->integer('tds');
            $table->integer('fbp');
            $table->integer('creator_user_id');
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
        Schema::dropIfExists('vmt_paygroup');
    }
};
