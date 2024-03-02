<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Seeder_VmtPayrollCompTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('vmt_payroll_comp_types')->truncate();

        DB::table('vmt_payroll_comp_types')->insert([
            ['id'=>'1','name'=>'fixed'],
            ['id'=>'2','name'=>'variable'],

        ]);
    }
}
