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
        Schema::create('vmt_payroll_components', function (Blueprint $table) {
            $table->id();
            $table->text('comp_name');
            $table->integer('comp_type_id');
            $table->integer('comp_nature_id');
            $table->integer('category_id');
            $table->integer('calculation_method_id');
            $table->text('flat_amount');
            $table->text('percentage');
            $table->integer('epf');
            $table->integer('esi');
            $table->integer('is_part_of_empsal_structure');
            $table->integer('is_taxable');
            $table->integer('calculate_on_prorate_basis');
            $table->integer('can_show_inpayslip');
            $table->integer('impact_on_gross');
            $table->integer('maximum_limit');
            $table->integer('status');
            $table->integer('is_default');
            $table->integer('lwf');
            $table->integer('pt');
            $table->text('comp_name_payslip');
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
        Schema::dropIfExists('vmt_payroll_components');
    }
};
