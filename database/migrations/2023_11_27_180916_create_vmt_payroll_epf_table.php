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
    if (!Schema::hasTable('vmt_payroll_epf')) {
        Schema::create('vmt_payroll_epf', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->text('epf_number');
            $table->text('epf_deduction_cycle');
            $table->text('is_epf_num_default');
            $table->text('epf_rule');
            $table->text('epf_contrib_type');
            $table->integer('pro_rated_lop_status');
            $table->integer('can_consider_salcomp_pf');
            $table->integer('employer_contrib_in_ctc');
            $table->integer('employer_edli_contri_in_ctc');
            $table->integer('admin_charges_in_ctc');
            $table->integer('override_pf_contrib_rate');
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
        Schema::dropIfExists('vmt_payroll_epf');
    }
};
