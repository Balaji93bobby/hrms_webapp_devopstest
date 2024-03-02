<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use carbon\carbon;

class seed_SalaryRevisionFrequency extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('vmt_salary_revision_frequencies')->truncate();

        DB::table('vmt_salary_revision_frequencies')->insert([

            ['id'=>'1','name'=>'Monthly','created_at'=>carbon::now()->format('Y-m-d H:i:s')],
            ['id'=>'2','name'=>'Yearly','created_at'=>carbon::now()->format('Y-m-d H:i:s')],

        ]);
    }
}
