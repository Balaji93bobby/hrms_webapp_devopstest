<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Seeder_Core_Table extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            BloodGroupSeeder::class,
            VmtHolidaysSeeder::class,
            OrgRolesTableSeeder::class,
            //DepartmentTableSeeder::class,
            CountriesTableSeeder::class,
            StateTableSeeder::class,
            BankTableSeeder::class,
            Seeder_VmtMaritalStatus::class,
            //LeaveTableSeeder::class,


        ]);


    }
}
