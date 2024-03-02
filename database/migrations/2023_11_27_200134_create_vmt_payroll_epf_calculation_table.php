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
        Schema::create('vmt_payroll_epf_calculation', function (Blueprint $table) {
            $table->id();
            $table->text('epf_rule');
            $table->text('epf_contribution_type');
            $table->text('epf_calculation_json');
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
        Schema::dropIfExists('vmt_payroll_epf_calculation');
    }
};
