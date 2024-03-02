<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('vmt_leaves')->truncate();

        DB::table('vmt_leaves')->insert([
            ['id'=>'1','leave_type'=>'Sick Leave/Casual Leave','days_annual'=>'12','days_monthly'=>'2','days_restricted'=>'3','is_finite'=>'1'],
            ['id'=>'2','leave_type'=>'Earned Leave','days_annual'=>'12','days_monthly'=>'2','days_restricted'=>'2','is_finite'=>'1'],
            ['id'=>'3','leave_type'=>'Maternity Leave','days_annual'=>'84','days_monthly'=>'3','days_restricted'=>'0','is_finite'=>'1'],
            ['id'=>'4','leave_type'=>'Paternity Leave','days_annual'=>'15','days_monthly'=>'3','days_restricted'=>'1','is_finite'=>'1'],
            ['id'=>'5','leave_type'=>'On Duty','days_annual'=>'15','days_monthly'=>'3','days_restricted'=>'1','is_finite'=>'1'],
            ['id'=>'6','leave_type'=>'Permission','days_annual'=>'-1','days_monthly'=>'-1','days_restricted'=>'-1','is_finite'=>'1'],
            ['id'=>'7','leave_type'=>'Compensatory Off','days_annual'=>'0','days_monthly'=>'0','days_restricted'=>'0','is_finite'=>'0'],

        ]);
    }
}
