<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use carbon\carbon;

class seeder_PayFrequency extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('vmt_pay_frequency')->truncate();

        DB::table('vmt_pay_frequency')->insert([

            ['id'=>'1','name'=>'Monthly','status'=>'1','created_at'=>carbon::now()->format('Y-m-d H:i:s')],
            ['id'=>'2','name'=>'Weekly','status'=>'0','created_at'=>carbon::now()->format('Y-m-d H:i:s')],
            ['id'=>'3','name'=>'Daily','status'=>'0','created_at'=>carbon::now()->format('Y-m-d H:i:s')],
        ]);
    }
}
