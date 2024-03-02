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
        Schema::create('vmt_employee_statutory_details', function (Blueprint $table) {
            $table->id();
            $table->text('user_id');
            $table->text('uan_number');
            $table->text('pf_applicable');
            $table->text('esic_applicable');
            $table->text('ptax_location');
            $table->text('tax_regime');
            $table->text('lwf_location');
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
        Schema::dropIfExists('vmt_employee_statutory_details');
    }
};
