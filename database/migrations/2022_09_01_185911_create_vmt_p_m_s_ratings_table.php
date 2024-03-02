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
        Schema::create('vmt_pms_rating', function (Blueprint $table) {
            $table->id();
            $table->text('score_range')->nullable();//60 to 70, etc
            $table->text('performance_rating')->nullable(); //Needs Action,etc
            $table->text('ranking')->nullable();//1,2,3,4,5
            $table->text('action')->nullable();//Exit,PIP,10%,etc
            $table->text('sort_order')->nullable();//Used to sort in view
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
        Schema::dropIfExists('vmt_p_m_s_ratings');
    }
};
