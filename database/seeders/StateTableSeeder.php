<?php

namespace Database\Seeders;

use App\Models\Countries;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('vmt_states')->truncate();

        $country_id = Countries::where('country_name', 'India')->first()->id;

        DB::table('vmt_states')->insert([
            ['id'=>'1','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Andhra Pradesh', 'status' => 'A'],
            ['id'=>'2','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Andaman and Nicobar Islands', 'status' => 'A'],
            ['id'=>'3','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Arunachal Pradesh', 'status' => 'A'],
            ['id'=>'4','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Assam', 'status' => 'A'],
            ['id'=>'5','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Bihar', 'status' => 'A'],
            ['id'=>'6','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Chandigarh', 'status' => 'A'],
            ['id'=>'7','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Chhattisgarh', 'status' => 'A'],
            ['id'=>'8','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Dadar and Nagar Haveli', 'status' => 'A'],
            ['id'=>'9','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Daman and Diu', 'status' => 'A'],
            ['id'=>'10','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Delhi', 'status' => 'A'],
            ['id'=>'11','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Lakshadweep', 'status' => 'A'],
            ['id'=>'12','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Puducherry', 'status' => 'A'],
            ['id'=>'13','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Goa', 'status' => 'A'],
            ['id'=>'14','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Gujarat', 'status' => 'A'],
            ['id'=>'15','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Haryana', 'status' => 'A'],
            ['id'=>'16','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Himachal Pradesh', 'status' => 'A'],
            ['id'=>'17','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Jammu and Kashmir', 'status' => 'A'],
            ['id'=>'18','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Jharkhand', 'status' => 'A'],
            ['id'=>'19','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Karnataka', 'status' => 'A'],
            ['id'=>'20','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Kerala', 'status' => 'A'],
            ['id'=>'21','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Madhya Pradesh', 'status' => 'A'],
            ['id'=>'22','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Maharashtra', 'status' => 'A'],
            ['id'=>'23','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Manipur', 'status' => 'A'],
            ['id'=>'24','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Meghalaya', 'status' => 'A'],
            ['id'=>'25','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Mizoram', 'status' => 'A'],
            ['id'=>'26','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Nagaland', 'status' => 'A'],
            ['id'=>'27','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Odisha', 'status' => 'A'],
            ['id'=>'28','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Punjab', 'status' => 'A'],
            ['id'=>'29','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Rajasthan', 'status' => 'A'],
            ['id'=>'30','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Sikkim', 'status' => 'A'],
            ['id'=>'31','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Tamil Nadu', 'status' => 'A'],
            ['id'=>'32','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Telangana', 'status' => 'A'],
            ['id'=>'33','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Tripura', 'status' => 'A'],
            ['id'=>'34','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Uttar Pradesh', 'status' => 'A'],
            ['id'=>'35','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'Uttarakhand', 'status' => 'A'],
            ['id'=>'36','country_id'=>$country_id, 'country_code' => 'IN', 'state_name'=>'West Bengal', 'status' => 'A']
        ]);
    }
}
