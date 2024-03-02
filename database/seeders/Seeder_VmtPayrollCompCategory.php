<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Seeder_VmtPayrollCompCategory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('vmt_payroll_comp_category')->truncate();

        DB::table('vmt_payroll_comp_category')->insert([
            ['id'=>'1','name'=>'earnings'],
            ['id'=>'2','name'=>'deduction'],
            ['id'=>'3','name'=>'adhoc'],
            ['id'=>'4','name'=>'reimbursement'],
        ]);
    }
}
