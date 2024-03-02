<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Seeder_ExternalApps extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vmt_externalapps')->truncate();
        DB::table('vmt_externalapps')->insert([
            //id 	name 	internal_name 	description 	app_logo 	created_at 	updated_at
            ['id'=>'1','name'=>'Tally ERP','internal_name'=>'tally_erp','description'=>'This is Tally ERP description','app_logo'=>'image.jpg' , 'created_at'=>Carbon::now()],
            ['id'=>'2','name'=>'Zoho Books','internal_name'=>'zoho_books','description'=>'This is Zoho Books description','app_logo'=>'image.jpg', 'created_at'=>Carbon::now()],
            ['id'=>'3','name'=>'SAP','internal_name'=>'sap','description'=>'This is SAP description','app_logo'=>'image.jpg', 'created_at'=>Carbon::now()],
            ['id'=>'4','name'=>'Ledgers','internal_name'=>'ledgers','description'=>'This is Ledgers description','app_logo'=>'image.jpg', 'created_at'=>Carbon::now()],
        ]);
    }
}
