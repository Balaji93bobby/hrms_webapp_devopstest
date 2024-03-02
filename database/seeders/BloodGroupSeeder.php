<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BloodGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vmt_bloodgroup')->truncate();

        DB::table('vmt_bloodgroup')->insert([
            ['id'=>'1','name'=> 'A Positive'],
            ['id'=>'2','name'=> 'A Negative'],
            ['id'=>'3','name'=> 'B Positive'],
            ['id'=>'4','name'=> 'B Negative'],
            ['id'=>'5','name'=> 'AB Positive'],
            ['id'=>'6','name'=> 'AB Negative'],
            ['id'=>'7','name'=> 'O Positive'],
            ['id'=>'8','name'=> 'O Negative'],
        ]);
    }
}
