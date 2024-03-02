<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\VmtClientMaster;

class LoansalAdvMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vmt_loan_sal_adv_master')->truncate();
        $all_clinets = VmtClientMaster::get();
        foreach ($all_clinets as $single_client) {
            DB::table('vmt_loan_sal_adv_master')->insert([
                'client_id' => $single_client->id
            ]);
        }
    }
}
