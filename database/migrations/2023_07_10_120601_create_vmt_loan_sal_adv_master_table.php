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
        Schema::create('vmt_loan_sal_adv_master', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('vmt_client_master');
            $table->integer('sal_adv')->default(0);
            $table->integer('int_free_loan')->default(0);
            $table->integer('loan_with_int')->default(0);
            $table->integer('travel_adv')->default(0);
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
        Schema::dropIfExists('vmt_loan_sal_adv_master');
    }
};
