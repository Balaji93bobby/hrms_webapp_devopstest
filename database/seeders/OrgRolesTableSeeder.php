<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrgRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         //Delete old data
         DB::table('vmt_org_roles')->truncate();


          DB::table('vmt_org_roles')->insert([
            ['id'=>'1','name'=> 'Super Admin', 'email'=>'test@gmail.com','is_active' => 1,'created_at' => now(),'updated_at' => now()],
            ['id'=>'2','name'=> 'Admin', 'email'=>'test@gmail.com','is_active' => 1,'created_at' => now(),'updated_at' => now()],
            ['id'=>'3','name'=> 'HR', 'email'=>'test@gmail.com','is_active' => 1,'created_at' => now(),'updated_at' => now()],
            ['id'=>'4','name'=> 'Manager', 'email'=>'test@gmail.com','is_active' => 1,'created_at' => now(),'updated_at' => now()],
            ['id'=>'5','name'=> 'Employee', 'email'=>'test@gmail.com','is_active' => 1,'created_at' => now(),'updated_at' => now()],
        ]);
    }
}
