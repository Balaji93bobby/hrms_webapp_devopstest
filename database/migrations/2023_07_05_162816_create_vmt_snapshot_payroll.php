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
        Schema::create('vmt_snapshot_payroll', function (Blueprint $table) {
            $table->id();
            $table->text('employee_code');
            $table->text('employee_name');
            $table->text('gender');
            $table->text('designation');
            $table->date('doj');
            $table->date('dob');
            $table->text('pay_group_id');
            $table->text('employment_status');
            $table->text('location');
            $table->text('business_unit');
            $table->text('cost_center');
            $table->text('legal_entity');
            $table->integer('aadhaar_number');
            $table->text('pan_number');
            $table->integer('uan_number');
            $table->text('epf_number');
            $table->text('esic_number');
            $table->text('bank_name');
            $table->text('bank_account_number');
            $table->text('bank_ifsc_code');
            $table->integer('mobile_number');
            $table->text('email_id');
            $table->text('abry');
            $table->date('payroll_month');
            $table->integer('fixed_gross_amount');
            $table->integer('basic');
            $table->integer('dearness_allowance');
            $table->integer('vda');
            $table->integer('hra');
            $table->integer('child_education_allowance');
            $table->integer('communication_allowance');
            $table->integer('food_allowance');
            $table->integer('leave_travel_allowance');
            $table->integer('special_allowance');
            $table->integer('other_allowance');
            $table->integer('vehicle_reimbursement');
            $table->integer('driver_salary');
            $table->integer('washing_allowance');
            $table->integer('unifrom_allowance');
            $table->integer('total_fixed_gross');
            $table->integer('month_days');
            $table->integer('worked_days');
            $table->integer('arrears_days');
            $table->integer('LOP');
            $table->integer('earned_basic');
            $table->integer('basic_arrears');
            $table->integer('earned_dearness_allowance');
            $table->integer('dearness_allowance_arrears');
            $table->integer('earned_vda');
            $table->integer('vda_arrears');
            $table->integer('earned_hra');
            $table->integer('hra_arrears');
            $table->integer('earned_special_allowance');
            $table->integer('special_allowance_arrears');
            $table->integer('earned_other_allowance');
            $table->integer('earned_vehicle_reimbursement');
            $table->integer('vehicle_reimbursement_arrears');
            $table->integer('earned_driver_salary');
            $table->integer('driver_salary_arrears');
            $table->integer('earned_washing_allowance');
            $table->integer('washing_allowance_arrears');
            $table->integer('earned_unifrom_allowance');
            $table->integer('unifrom_allowance_arrears');
            $table->integer('overtime');
            $table->integer('incentive');
            $table->integer('other_earnings');
            $table->integer('leave_encashment');
            $table->integer('referral_bonus');
            $table->integer('statutory_bonus');
            $table->integer('ex_gratia');
            $table->integer('gift_payment');
            $table->integer('attendance_bonus');
            $table->integer('daily_allowance');
            $table->integer('total_earned_gross');
            $table->integer('epf_wages');
            $table->integer('epf_wages_arrears');
            $table->integer('epf_employer');
            $table->integer('epf_er_arrears');
            $table->integer('edli_charges');
            $table->integer('edli_charges_arrears');
            $table->integer('epf_admin_charges');
            $table->integer('epf_admin_charges_arrears');
            $table->integer('employer_esic');
            $table->integer('employer_lwf');
            $table->integer('ctc');
            $table->integer('epf_employee');
            $table->integer('vpf_employee');
            $table->integer('epf_ee_Arrear');
            $table->integer('employee_esic');
            $table->integer('professional_tax');
            $table->integer('income_tax');
            $table->integer('salary_advance');
            $table->integer('medical_deductions');
            $table->integer('canteen_deduction');
            $table->integer('uniform_deduction');
            $table->integer('loan_deduction');
            $table->integer('other_deductions');
            $table->integer('lwf');
            $table->integer('total_deductions');
            $table->integer('net_salary_payable');
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
        Schema::dropIfExists('vmt_snapshot_payroll');
    }
};
