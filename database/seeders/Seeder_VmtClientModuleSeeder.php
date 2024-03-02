<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\VmtAppModules;
use App\Models\VmtClientMaster;
use App\Models\VmtAppSubModuleslink;
class Seeder_VmtClientModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('vmt_client_modules')->truncate();

        $client_id = VmtClientMaster::get();

        $Module_id = VmtAppModules::get();

  foreach ($Module_id as $key => $single_value) {

        foreach ($client_id as $key => $single_id) {

            DB::table('vmt_client_modules')->insert([

                ['client_id'=>$single_id['id'],'module_id'=>$single_value['id'],'status'=>'1'],

            ]);
        }
    }

        DB::table('vmt_client_sub_modules')->truncate();

        $sub_module_link_id = VmtAppSubModuleslink::get();

  foreach ($sub_module_link_id as $key => $single_sub_value) {

        foreach ($client_id as $key => $single_cl_id) {

            DB::table('vmt_client_sub_modules')->insert([

                ['client_id'=>$single_cl_id['id'],'app_sub_module_link_id'=>$single_sub_value['id'],'status'=>'0'],

            ]);
        }
    }
    }
}
