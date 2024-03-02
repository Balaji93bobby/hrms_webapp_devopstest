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
        Schema::table('vmt_payroll_components', function (Blueprint $table) {
            //

            if (!Schema::hasColumn('vmt_payroll_components', 'is_tptax_deduc_samemonth')) {
                $table->date('is_tptax_deduc_samemonth')->nullable()->after('is_taxable');
            }
            if (!Schema::hasColumn('vmt_payroll_components', 'comp_identifier')) {
                $table->text('comp_identifier')->nullable()->after('comp_name_payslip');
            }
            if (!Schema::hasColumn('vmt_payroll_components', 'calculation_desc')) {
                $table->text('calculation_desc')->nullable()->after('comp_identifier');
            }
            if (!Schema::hasColumn('vmt_payroll_components', 'comp_calculation_json')) {
                $table->text('comp_calculation_json')->nullable()->after('calculation_desc');
            }
            if (!Schema::hasColumn('vmt_payroll_components', 'is_separate_payment_allowed')) {
                $table->date('is_separate_payment_allowed')->nullable();
            }
            if (Schema::hasColumn('vmt_payroll_components', 'lwf')) {
                $table->renameColumn('lwf','is_part_of_lwf');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'pt')) {
                $table->renameColumn('pt','is_part_of_pt');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'status')) {
                $table->renameColumn('status','enabled_status');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'maximum_limit')) {
                $table->renameColumn('maximum_limit','reimburst_max_limit');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'impact_on_gross')) {
                $table->renameColumn('impact_on_gross','is_deduc_impacton_gross');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'calculation_method')) {
                $table->renameColumn('calculation_method','calculation_method_id');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'epf')) {
                $table->renameColumn('epf','is_part_of_epf');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'esi')) {
                $table->renameColumn('esi','is_part_of_esi');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vmt_payroll_components', function (Blueprint $table) {
            //
            if (Schema::hasColumn('vmt_payroll_components', 'comp_calculation_json')) {
                $table->dropColumn('comp_calculation_json');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'comp_identifier')) {
                $table->dropColumn('comp_identifier');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'calculation_desc')) {
                $table->dropColumn('calculation_desc');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'can_payouton_samemonth')) {
                $table->dropColumn('can_payouton_samemonth');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'is_part_of_lwf')) {
                $table->renameColumn('is_part_of_lwf','lwf');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'is_part_of_pt')) {
                $table->renameColumn('is_part_of_pt','pt');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'enabled_status')) {
                $table->renameColumn('enabled_status','status');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'reimburst_max_limit')) {
                $table->renameColumn('reimburst_max_limit','maximum_limit');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'is_dec_impacton_gross')) {
                $table->renameColumn('is_dec_impacton_gross','impact_on_gross');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'calculation_method_id')) {
                $table->renameColumn('calculation_method_id','calculation_method');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'is_part_of_epf')) {
                $table->renameColumn('is_part_of_epf','epf');
            }
            if (Schema::hasColumn('vmt_payroll_components', 'is_part_of_esi')) {
                $table->renameColumn('is_part_of_esi','esi');
            }
        });
    }
};
