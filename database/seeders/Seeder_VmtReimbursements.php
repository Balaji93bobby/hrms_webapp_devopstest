<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Seeder_VmtReimbursements extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vmt_reimbursements')->truncate();

        DB::table('vmt_reimbursements')->insert([
            ['id'=>'1','reimbursement_type'=>'Local Conveyance','active'=>'1'],
            ['id'=>'2','reimbursement_type'=>'Travel','active'=>'1'],
        ]);
    }
}
