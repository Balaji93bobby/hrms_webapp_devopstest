<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('vmt_department')->truncate();

        DB::table('vmt_department')->insert([
            ['id'=>'1','name'=> 'IT', 'created_at' => now()],
            ['id'=>'2','name'=> 'Sales', 'created_at' => now()],
            ['id'=>'3','name'=> 'HR', 'created_at' => now()],
            ['id'=>'4','name'=> 'Support', 'created_at' => now()],
            ['id'=>'5','name'=> 'Leadership', 'created_at' => now()],
            ['id'=>'6','name'=> 'Production', 'created_at' => now()],
            ['id'=>'7','name'=> 'Client Service', 'created_at' => now()],
            ['id'=>'8','name'=> 'Business Development', 'created_at' => now()],
            ['id'=>'9','name'=> 'Management', 'created_at' => now()],
            ['id'=>'10','name'=> 'Finance', 'created_at' => now()],
            ['id'=>'11','name'=> 'Admin', 'created_at' => now()],
            ['id'=>'12','name'=> 'Creative', 'created_at' => now()],
        ]);
    }
}
