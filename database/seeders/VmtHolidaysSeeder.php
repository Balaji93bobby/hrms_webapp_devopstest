<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VmtHolidaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('vmt_holidays')->truncate();

        DB::table('vmt_holidays')->insert([
            ['id'=>'1','holiday_name' => 'Pongal', 'holiday_date' => '2022-01-16 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => 'pongal.jpg'],
            ['id'=>'2','holiday_name' => 'Republic Day', 'holiday_date' => '2022-01-16 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => 'republic_day_jan_26.jpg'],
            ['id'=>'3','holiday_name' => 'Good Friday', 'holiday_date' => '2022-04-17 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => 'Good Friday.jpg'],
            ['id'=>'4','holiday_name' => 'May Day', 'holiday_date' => '2022-05-01 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => 'MayDay.jpg'],
            ['id'=>'5','holiday_name' => 'Independance Day', 'holiday_date' => '2022-08-15 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => 'independence.jpg'],
            ['id'=>'6','holiday_name' => 'Gandhi Jayanthi', 'holiday_date' =>	'2022-10-02 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => 'gandhi_jayandhi.png'],
            ['id'=>'7','holiday_name' => 'Ganesh Chadurthi', 'holiday_date' => '2022-09-19 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => 'ganesh_chadurthi.png'],
            ['id'=>'8','holiday_name' => 'Ayutha puja', 'holiday_date' => '2022-10-23 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => 'aazhutha pooja.png'],
            ['id'=>'9','holiday_name' => 'Vijaya Dhashami', 'holiday_date' => '2022-10-24 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => 'vijaya dashami.png'],
            ['id'=>'10','holiday_name' => 'Diwali', 'holiday_date' => '2022-11-13 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => 'diwali.png'],
            ['id'=>'11','holiday_name' => 'Christmas', 'holiday_date' => '2022-12-25 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => 'christmas.png'],
            ['id'=>'12','holiday_name' => 'Thiruvallur Day', 'holiday_date' => '2022-01-16 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => ''],
            ['id'=>'13','holiday_name' => 'Saraswathi Pooja', 'holiday_date' => '2022-01-26 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => ''],
            ['id'=>'14','holiday_name' => 'Doljatra', 'holiday_date' => '2022-03-07 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => ''],
            ['id'=>'15','holiday_name' => 'Holi', 'holiday_date' => '2022-03-09 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => ''],
            ['id'=>'16','holiday_name' => 'Holi', 'holiday_date' => '2022-03-10 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => ''],
            ['id'=>'17','holiday_name' => 'Tamil New Year', 'holiday_date' => '2022-04-14 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => ''],
            ['id'=>'18','holiday_name' => 'Ramzan', 'holiday_date' => '2022-04-22 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => ''],
            ['id'=>'19','holiday_name' => 'Bengali New Year', 'holiday_date' => '2022-05-15 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => ''],
            ['id'=>'20','holiday_name' => 'Raksha Bandham', 'holiday_date' => '2022-08-30 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => ''],
            ['id'=>'21','holiday_name' => 'Raksha Bandham', 'holiday_date' => '2022-08-31 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => ''],
            ['id'=>'22','holiday_name' => 'Maha Ashtami', 'holiday_date' => '2022-10-21 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => ''],
            ['id'=>'23','holiday_name' => 'Maha Ashtami', 'holiday_date' => '2022-10-22 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => ''],
            ['id'=>'24','holiday_name' => 'Maha Navami', 'holiday_date' => '2022-10-23 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => ''],
            ['id'=>'25','holiday_name' => 'Dussehra', 'holiday_date' => '2022-10-24 00:00:00', 'holiday_description' => 'Government Holiday', 'image' => ''],

        ]);

}

}
