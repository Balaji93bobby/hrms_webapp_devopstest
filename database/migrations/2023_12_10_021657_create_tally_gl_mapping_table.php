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
        Schema::create('vmt_tally_gl_mappings', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->foreignId('payroll_comp_id')->constrained('vmt_payroll_components');
            $table->string('tally_gl_head');
            $table->string('tally_gl_name');
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
        Schema::dropIfExists('vmt_tally_gl_mappings');
    }
};
