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
        Schema::table('vmt_attendance_cycle', function (Blueprint $table) {
            //

             //rename
             if (Schema::hasColumn('vmt_attendance_cycle', 'post_attendance_cutoff_date')) {
                $table->renameColumn('post_attendance_cutoff_date','attendance_cutoff_date');
            }
            if (Schema::hasColumn('vmt_attendance_cycle', 'emp_attedance_cutoff_date')) {
                $table->renameColumn('emp_attedance_cutoff_date','is_attcutoff_diff_payenddate');
            }
        // add new columnn
            if (!Schema::hasColumn('vmt_attendance_cycle', 'payroll_cycle_id')) {
                $table->foreignId('payroll_cycle_id')->constrained('vmt_payroll_cycle')->after('id');
            }

            if (!Schema::hasColumn('vmt_attendance_cycle', 'attendance_start_date')) {
                $table->date('attendance_start_date')->nullable();
            }
            if (!Schema::hasColumn('vmt_attendance_cycle', 'attendance_end_date')) {
                $table->date('attendance_end_date')->nullable()->after('attendance_start_date');
            }

            if (!Schema::hasColumn('vmt_attendance_cycle', 'is_payperiod_same_att_period')) {
                $table->integer('is_payperiod_same_att_period')->nullable()->after('attendance_end_date');
            }

    //drop column
            if (Schema::hasColumn('vmt_attendance_cycle', 'att_cutoff_period_id')) {
                $table->dropColumn('att_cutoff_period_id');
            }
    //change datatype
            if (Schema::hasColumn('vmt_payroll_cycle', 'is_attcutoff_diff_payenddate')) {
                $table->integer('is_attcutoff_diff_payenddate')->change();
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
        Schema::table('vmt_attendance_cycle', function (Blueprint $table) {
            //create

            if (Schema::hasColumn('vmt_attendance_cycle', 'payroll_cycle_id')) {
                $table->dropConstrainedForeignId('payroll_cycle_id');
            }
            if (Schema::hasColumn('vmt_attendance_cycle', 'is_payperiod_same_att_period')) {
                $table->dropColumn('is_payperiod_same_att_period');
            }
            if (Schema::hasColumn('vmt_attendance_cycle', 'attendance_start_date')) {
                $table->dropColumn('attendance_start_date');
            }
            if (Schema::hasColumn('vmt_attendance_cycle', 'attendance_end_date')) {
                $table->dropColumn('attendance_end_date');
            }
       //rename
            if (Schema::hasColumn('vmt_attendance_cycle', 'attendance_cutoff_date')) {
                $table->renameColumn('attendance_cutoff_date','post_attendance_cutoff_date');
            }
            if (Schema::hasColumn('vmt_attendance_cycle', 'is_attcutoff_diff_payenddate')) {
                $table->renameColumn('is_attcutoff_diff_payenddate','emp_attedance_cutoff_date');
            }
      //drop
            if (!Schema::hasColumn('vmt_attendance_cycle', 'att_cutoff_period_id')) {
                $table->integer('att_cutoff_period_id')->nullable();
            }
    //change datatype
            if (Schema::hasColumn('vmt_attendance_cycle', 'is_attcutoff_diff_payenddate')) {
                $table->date('is_attcutoff_diff_payenddate')->change();
            }
        });
    }
};
