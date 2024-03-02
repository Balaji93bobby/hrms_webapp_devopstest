<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Seeder_VmtPayrollCompCalculationMethod extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('vmt_payroll_calculatiom_method')->truncate();

        DB::table('vmt_payroll_calculatiom_method')->insert([
            ['id'=>'1','name'=>'flat amount'],
            ['id'=>'2','name'=>'percentage'],
        ]);
    }
}
