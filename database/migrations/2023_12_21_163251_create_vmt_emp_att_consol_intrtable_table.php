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
        Schema::create('vmt_emp_att_consol_intrtable', function (Blueprint $table) {
            $table->id();
            $table->date('month');
            $table->unsignedBigInteger('user_id');
            $table->integer('weekoff')->default(0);
            $table->integer('holiday')->default(0);
            $table->integer('present')->default(0);
            $table->integer('absent')->default(0);
            $table->integer('lc_eg_lop')->default(0);
            $table->integer('leave')->default(0);
            $table->integer('halfday')->default(0);
            $table->integer('on_duty')->default(0);
            $table->integer('lc')->default(0);
            $table->integer('eg')->default(0);
            $table->integer('payable_days')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vmt_emp_att_consol_intrtable');
    }
};
