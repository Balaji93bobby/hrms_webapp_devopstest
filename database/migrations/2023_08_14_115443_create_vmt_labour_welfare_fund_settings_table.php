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
        Schema::create('vmt_labour_welfare_fund_settings', function (Blueprint $table) {
            $table->id();
            $table->text('client_id')->constrained('vmt_client_master');
            $table->text('state');
            $table->text('employees_contribution');
            $table->text('deduction_cycle');
            $table->text('employers_contribution');
            $table->text('employees');
            $table->integer('status');
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
        Schema::dropIfExists('vmt_labour_welfare_fund_settings');
    }
};
