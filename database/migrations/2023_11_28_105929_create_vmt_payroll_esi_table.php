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
    if (!Schema::hasTable('vmt_payroll_esi')) {
        Schema::create('vmt_payroll_esi', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->text('esi_number');
            $table->text('esi_deduction_cycle');
            $table->text('state');
            $table->text('location');
            $table->text('employee_contribution_rate');
            $table->text('employer_contribution_rate');
            $table->integer('employer_contribution_in_ctc');
            $table->integer('status');
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vmt_payroll_esi');
    }
};
