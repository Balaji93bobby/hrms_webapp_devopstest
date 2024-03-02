<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Seeder_VmtMaritalStatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('vmt_marital_status')->truncate();

        DB::table('vmt_marital_status')->insert([
            ['id'=>'1','name'=>'Unmarried'],
            ['id'=>'2','name'=>'Married'],
            ['id'=>'3','name'=>'Separated'],
            ['id'=>'4','name'=>'Widowed'],
            ['id'=>'5','name'=>'Divorced'],
        ]);
    }
}
