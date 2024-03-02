<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Seeder_VmtPayrollCompNature extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('vmt_payroll_comp_nature')->truncate();

        DB::table('vmt_payroll_comp_nature')->insert([
            ['id'=>'1','name'=>'allowance'],
            ['id'=>'2','name'=>'reimbursement'],
            ['id'=>'3','name'=>'variable'],
            ['id'=>'4','name'=>'statutory'],

        ]);
    }
}
