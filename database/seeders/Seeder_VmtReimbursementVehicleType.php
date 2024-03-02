<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Seeder_VmtReimbursementVehicleType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vmt_reimbursement_vehicle_types')->truncate();

        DB::table('vmt_reimbursement_vehicle_types')->insert([
            ['id'=>'1','vehicle_type'=>'2-Wheeler','cost_per_km'=>'3.5'],
            ['id'=>'2','vehicle_type'=>'4-Wheeler','cost_per_km'=>'6'],
        ]);
    }
}
