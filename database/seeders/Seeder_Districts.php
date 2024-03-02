<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use carbon\carbon;

class Seeder_Districts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //


        DB::table('districts')->truncate();

        $districts=[ "Ariyalur","Chengalpattu"," Chennai","Coimbatore","Cuddalore","Dharmapuri","Dindigul","Erode","Kallakurichi","Kanchipuram","Kanyakumari",
                     "Karur","Krishnagiri","Madurai","Nagapattinam","Namakkal","Nilgiris","Perambalur","Pudukkottai","Ramanathapuram","Ranipet","Salem","Sivaganga",
                     "Tenkasi","Thanjavur","Theni","Thoothukudi","Tiruchirappalli","Tirunelveli","Tirupathur","Tiruppur","Tiruvallur","Tiruvannamalai","Tiruvarur","Vellore","Villuppuram","Virudhunagar"];

        foreach ( $districts as $key => $single_district) {

            DB::table('districts')->insert([
                ['district_name'=>$single_district,'created_at'=>carbon::now()->format('Y-m-d H:i:s'),'updated_at'=>carbon::now()->format('Y-m-d H:i:s')]

            ]);
        }

    }
}
