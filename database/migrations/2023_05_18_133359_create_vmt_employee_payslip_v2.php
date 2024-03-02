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
        Schema::create('vmt_employee_payslip_v2', function (Blueprint $table) {

            $table->id();
            $table->foreignId('emp_payroll_id')->constrained('vmt_emp_payroll');
            $table->text('gender')->nullable();
            $table->text('designation')->nullable();
            $table->text('department')->nullable();
            $table->date('doj')->nullable();
            $table->text('location')->nullable();
            $table->date('dob')->nullable();
            $table->text('father_name')->nullable();
            $table->text('pan_number')->nullable();
            $table->text('aadhar_number')->nullable();
            $table->text('uan')->nullable();
            $table->text('epf_number')->nullable();
            $table->text('esic_number')->nullable();
            $table->text('Bank_Name')->nullable();
            $table->text('account_number')->nullable();
            $table->text('bank_ifsc_code')->nullable();
            $table->text('basic')->nullable();
            $table->text('hra')->nullable();
            $table->text('child_edu_allowance')->nullable();
            $table->text('spl_alw')->nullable();
            $table->text('total_fixed_gross')->nullable();
            $table->text('month_days')->nullable();
            $table->text('worked_Days')->nullable();
            $table->text('arrears_Days')->nullable();
            $table->text('lop')->nullable();
            $table->text('earned_basic')->nullable();
            $table->text('basic_arrear')->nullable();
            $table->text('earned_hra')->nullable();
            $table->text('hra_arrear')->nullable();
            $table->text('earned_child_edu_allowance')->nullable();
            $table->text('child_edu_allowance_arrear')->nullable();
            $table->text('earned_spl_alw')->nullable();
            $table->text('spl_alw_arrear')->nullable();
            $table->text('overtime')->nullable();
            $table->text('total_earned_gross')->nullable();
            $table->text('pf_wages')->nullable();
            $table->text('pf_wages_arrear_epfr')->nullable();
            $table->text('epfr')->nullable();
            $table->text('epfr_arrear')->nullable();
            $table->text('edli_charges')->nullable();
            $table->text('edli_charges_arrears')->nullable();
            $table->text('pf_admin_charges')->nullable();
            $table->text('pf_admin_charges_arrears')->nullable();
            $table->text('employer_esi')->nullable();
            $table->text('employer_lwf')->nullable();
            $table->text('ctc')->nullable();
            $table->text('epf_ee')->nullable();
            $table->text('epf_ee_arrear')->nullable();
            $table->text('employee_esic')->nullable();
            $table->text('prof_tax')->nullable();
            $table->text('income_tax')->nullable();
            $table->text('sal_adv')->nullable();
            $table->text('canteen_dedn')->nullable();
            $table->text('other_deduc')->nullable();
            $table->text('lwf')->nullable();
            $table->text('total_deductions')->nullable();
            $table->text('net_take_home')->nullable();
            $table->text('rupees')->nullable();
            $table->text('el_opn_bal')->nullable();
            $table->text('availed_el')->nullable();
            $table->text('balance_el')->nullable();
            $table->text('sl_opn_bal')->nullable();
            $table->text('availed_sl')->nullable();
            $table->text('balance_sl')->nullable();
            $table->text('rename')->nullable();
            $table->text('email')->nullable();
            $table->text('greetings')->nullable();
            $table->text('stats_bonus')->nullable();
            $table->text('earned_stats_bonus')->nullable();
            $table->text('earned_stats_arrear')->nullable();
            $table->text('travel_conveyance')->nullable();
            $table->text('other_earnings')->nullable();
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
        Schema::dropIfExists('vmt_employee_payslip_v2');
    }
};
