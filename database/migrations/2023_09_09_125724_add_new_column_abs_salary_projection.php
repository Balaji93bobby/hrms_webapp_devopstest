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
        Schema::table('abs_salary_projection', function (Blueprint $table) {
            //

            if (!Schema::hasColumn('abs_salary_projection', 'medical_allowance')) {
                $table->text('medical_allowance')->nullable()->after('child_edu_allowance_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'medical_allowance_earned')) {
                $table->text('medical_allowance_earned')->nullable()->after('medical_allowance');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'medical_allowance_arrear')) {
                $table->text('medical_allowance_arrear')->nullable()->after('medical_allowance_earned');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'lta')) {
                $table->text('lta')->nullable()->after('medical_allowance_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'earned_lta')) {
                $table->text('earned_lta')->nullable()->after('lta');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'lta_arrear')) {
                $table->text('lta_arrear')->nullable()->after('earned_lta');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'dearness_allowance')) {
                $table->text('dearness_allowance')->nullable()->after('lta_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'dearness_allowance_earned')) {
                $table->text('dearness_allowance_earned')->nullable()->after('dearness_allowance');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'dearness_allowance_arrear')) {
                $table->text('dearness_allowance_arrear')->nullable()->after('dearness_allowance_earned');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'vda')) {
                $table->text('vda')->nullable()->after('dearness_allowance_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'vda_earned')) {
                $table->text('vda_earned')->nullable()->after('vda');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'vda_arrear')) {
                $table->text('vda_arrear')->nullable()->after('vda_earned');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'vpf_arrear')) {
                $table->text('vpf_arrear')->nullable()->after('vda_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'communication_allowance')) {
                $table->text('communication_allowance')->nullable()->after('vpf_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'communication_allowance_earned')) {
                $table->text('communication_allowance_earned')->nullable()->after('communication_allowance');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'communication_allowance_arrear')) {
                $table->text('communication_allowance_arrear')->nullable()->after('communication_allowance_earned');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'food_allowance')) {
                $table->text('food_allowance')->nullable()->after('communication_allowance_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'food_allowance_earned')) {
                $table->text('food_allowance_earned')->nullable()->after('food_allowance');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'food_allowance_arrear')) {
                $table->text('food_allowance_arrear')->nullable()->after('food_allowance_earned');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'other_allowance')) {
                $table->text('other_allowance')->nullable()->after('food_allowance_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'other_allowance_earned')) {
                $table->text('other_allowance_earned')->nullable()->after('other_allowance');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'other_allowance_arrear')) {
                $table->text('other_allowance_arrear')->nullable()->after('other_allowance_earned');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'washing_allowance')) {
                $table->text('washing_allowance')->nullable()->after('other_allowance_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'washing_allowance_earned')) {
                $table->text('washing_allowance_earned')->nullable()->after('other_allowance_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'washing_allowance_arrear')) {
                $table->text('washing_allowance_arrear')->nullable()->after('washing_allowance_earned');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'uniform_allowance')) {
                $table->text('uniform_allowance')->nullable()->after('washing_allowance_earned');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'uniform_allowance_earned')) {
                $table->text('uniform_allowance_earned')->nullable()->after('uniform_allowance');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'uniform_allowance_arrear')) {
                $table->text('uniform_allowance_arrear')->nullable()->after('uniform_allowance_earned');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'vehicle_reimbursement')) {
                $table->text('vehicle_reimbursement')->nullable()->after('uniform_allowance_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'vehicle_reimbursement_earned')) {
                $table->text('vehicle_reimbursement_earned')->nullable()->after('vehicle_reimbursement');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'vehicle_reimbursement_arrear')) {
                $table->text('vehicle_reimbursement_arrear')->nullable()->after('vehicle_reimbursement_earned');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'driver_salary')) {
                $table->text('driver_salary')->nullable()->after('vehicle_reimbursement_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'driver_salary_earned')) {
                $table->text('driver_salary_earned')->nullable()->after('driver_salary');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'driver_salary_arrear')) {
                $table->text('driver_salary_arrear')->nullable()->after('driver_salary_earned');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'fuel_reimbursement')) {
                $table->text('fuel_reimbursement')->nullable()->after('driver_salary_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'fuel_reimbursement_earned')) {
                $table->text('fuel_reimbursement_earned')->nullable()->after('fuel_reimbursement');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'fuel_reimbursement_arrear')) {
                $table->text('fuel_reimbursement_arrear')->nullable()->after('fuel_reimbursement_earned');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'overtime_arrear')) {
                $table->text('overtime_arrear')->nullable()->after('overtime');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'incentive')) {
                $table->text('incentive')->nullable()->after('fuel_reimbursement_earned');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'incentive_arrear')) {
                $table->text('incentive_arrear')->nullable()->after('incentive');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'leave_encashment')) {
                $table->text('leave_encashment')->nullable()->after('incentive_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'leave_encashment_arrear')) {
                $table->text('leave_encashment_arrear')->nullable()->after('leave_encashment');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'referral_bonus')) {
                $table->text('referral_bonus')->nullable()->after('leave_encashment_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'referral_bonus_arrear')) {
                $table->text('referral_bonus_arrear')->nullable()->after('referral_bonus');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'statutory_bonus')) {
                $table->text('statutory_bonus')->nullable()->after('referral_bonus_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'statutory_bonus_arrear')) {
                $table->text('statutory_bonus_arrear')->nullable()->after('statutory_bonus');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'ex_gratia')) {
                $table->text('ex_gratia')->nullable()->after('statutory_bonus_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'gift_payment')) {
                $table->text('gift_payment')->nullable()->after('ex_gratia');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'gift_payment_arrear')) {
                $table->text('gift_payment_arrear')->nullable()->after('gift_payment');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'attendance_bonus')) {
                $table->text('attendance_bonus')->nullable()->after('gift_payment_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'attendance_bonus_arrear')) {
                $table->text('attendance_bonus_arrear')->nullable()->after('attendance_bonus');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'daily_allowance')) {
                $table->text('daily_allowance')->nullable()->after('attendance_bonus_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'daily_allowance_arrear')) {
                $table->text('daily_allowance_arrear')->nullable()->after('daily_allowance');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'salary_adv_arrear')) {
                $table->text('salary_adv_arrear')->nullable()->after('sal_adv');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'medical_deductions')) {
                $table->text('medical_deductions')->nullable()->after('salary_adv_arrear');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'uniform_deductions')) {
                $table->text('uniform_deductions')->nullable()->after('medical_deductions');
            }
            if (!Schema::hasColumn('abs_salary_projection', 'loan_deductions')) {
                $table->text('loan_deductions')->nullable()->after('uniform_deductions');
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
        Schema::table('abs_salary_projection', function (Blueprint $table) {
            //
            if (Schema::hasColumn('abs_salary_projection', 'medical_allowance')) {
                $table->dropColumn('medical_allowance');
            }
            if (Schema::hasColumn('abs_salary_projection', 'medical_allowance_earned')) {
                $table->dropColumn('medical_allowance_earned');
            }
            if (Schema::hasColumn('abs_salary_projection', 'medical_allowance_arrear')) {
                $table->dropColumn('medical_allowance_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'lta')) {
                $table->dropColumn('lta');
            }
            if (Schema::hasColumn('abs_salary_projection', 'earned_lta')) {
                $table->dropColumn('earned_lta');
            }
            if (Schema::hasColumn('abs_salary_projection', 'lta_arrear')) {
                $table->dropColumn('lta_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'dearness_allowance')) {
                $table->dropColumn('dearness_allowance');
            }
            if (Schema::hasColumn('abs_salary_projection', 'dearness_allowance_earned')) {
                $table->dropColumn('dearness_allowance_earned');
            }
            if (Schema::hasColumn('abs_salary_projection', 'dearness_allowance_arrear')) {
                $table->dropColumn('dearness_allowance_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'vda')) {
                $table->dropColumn('vda');
            }
            if (Schema::hasColumn('abs_salary_projection', 'vda_earned')) {
                $table->dropColumn('vda_earned');
            }
            if (Schema::hasColumn('abs_salary_projection', 'vda_arrear')) {
                $table->dropColumn('vda_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'vpf_arrear')) {
                $table->dropColumn('vpf_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'communication_allowance')) {
                $table->dropColumn('communication_allowance');
            }
            if (Schema::hasColumn('abs_salary_projection', 'communication_allowance_earned')) {
                $table->dropColumn('communication_allowance_earned');
            }
            if (Schema::hasColumn('abs_salary_projection', 'communication_allowance_arrear')) {
                $table->dropColumn('communication_allowance_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'food_allowance')) {
                $table->dropColumn('food_allowance');
            }
            if (Schema::hasColumn('abs_salary_projection', 'food_allowance_earned')) {
                $table->dropColumn('food_allowance_earned');
            }
            if (Schema::hasColumn('abs_salary_projection', 'food_allowance_arrear')) {
                $table->dropColumn('food_allowance_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'other_allowance')) {
                $table->dropColumn('other_allowance');
            }
            if (Schema::hasColumn('abs_salary_projection', 'other_allowance_earned')) {
                $table->dropColumn('other_allowance_earned');
            }
            if (Schema::hasColumn('abs_salary_projection', 'other_allowance_arrear')) {
                $table->dropColumn('other_allowance_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'washing_allowance')) {
                $table->dropColumn('washing_allowance');
            }
            if (Schema::hasColumn('abs_salary_projection', 'washing_allowance_earned')) {
                $table->dropColumn('washing_allowance_earned');
            }
            if (Schema::hasColumn('abs_salary_projection', 'washing_allowance_arrear')) {
                $table->dropColumn('washing_allowance_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'uniform_allowance')) {
                $table->dropColumn('uniform_allowance');
            }
            if (Schema::hasColumn('abs_salary_projection', 'uniform_allowance_earned')) {
                $table->dropColumn('uniform_allowance_earned');
            }
            if (Schema::hasColumn('abs_salary_projection', 'uniform_allowance_arrear')) {
                $table->dropColumn('uniform_allowance_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'vehicle_reimbursement')) {
                $table->dropColumn('vehicle_reimbursement');
            }
            if (Schema::hasColumn('abs_salary_projection', 'vehicle_reimbursement_earned')) {
                $table->dropColumn('vehicle_reimbursement_earned');
            }
            if (Schema::hasColumn('abs_salary_projection', 'vehicle_reimbursement_arrear')) {
                $table->dropColumn('vehicle_reimbursement_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'driver_salary')) {
                $table->dropColumn('driver_salary');
            }
            if (Schema::hasColumn('abs_salary_projection', 'driver_salary_earned')) {
                $table->dropColumn('driver_salary_earned');
            }
            if (Schema::hasColumn('abs_salary_projection', 'driver_salary_arrear')) {
                $table->dropColumn('driver_salary_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'fuel_reimbursement')) {
                $table->dropColumn('fuel_reimbursement');
            }
            if (Schema::hasColumn('abs_salary_projection', 'fuel_reimbursement_earned')) {
                $table->dropColumn('fuel_reimbursement_earned');
            }
            if (Schema::hasColumn('abs_salary_projection', 'fuel_reimbursement_arrear')) {
                $table->dropColumn('fuel_reimbursement_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'overtime_arrear')) {
                $table->dropColumn('overtime_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'incentive')) {
                $table->dropColumn('incentive');
            }
            if (Schema::hasColumn('abs_salary_projection', 'incentive_arrear')) {
                $table->dropColumn('incentive_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'leave_encashment')) {
                $table->dropColumn('leave_encashment');
            }
            if (Schema::hasColumn('abs_salary_projection', 'leave_encashment_arrear')) {
                $table->dropColumn('leave_encashment_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'referral_bonus')) {
                $table->dropColumn('referral_bonus');
            }
            if (Schema::hasColumn('abs_salary_projection', 'referral_bonus_arrear')) {
                $table->dropColumn('referral_bonus_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'statutory_bonus')) {
                $table->dropColumn('statutory_bonus');
            }
            if (Schema::hasColumn('abs_salary_projection', 'statutory_bonus_arrear')) {
                $table->dropColumn('statutory_bonus_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'ex_gratia')) {
                $table->dropColumn('ex_gratia');
            }
            if (Schema::hasColumn('abs_salary_projection', 'gift_payment')) {
                $table->dropColumn('gift_payment');
            }
            if (Schema::hasColumn('abs_salary_projection', 'gift_payment_arrear')) {
                $table->dropColumn('gift_payment_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'attendance_bonus')) {
                $table->dropColumn('attendance_bonus');
            }
            if (Schema::hasColumn('abs_salary_projection', 'attendance_bonus_arrear')) {
                $table->dropColumn('attendance_bonus_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'daily_allowance_arrear')) {
                $table->dropColumn('daily_allowance_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'salary_adv_arrear')) {
                $table->dropColumn('salary_adv_arrear');
            }
            if (Schema::hasColumn('abs_salary_projection', 'uniform_deductions')) {
                $table->dropColumn('uniform_deductions');
            }
            if (Schema::hasColumn('abs_salary_projection', 'medical_deductions')) {
                $table->dropColumn('medical_deductions');
            }
            if (Schema::hasColumn('abs_salary_projection', 'loan_deductions')) {
                $table->dropColumn('loan_deductions');
            }

        });
    }
};
