<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PmsRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('vmt_pms_rating')->truncate();

        DB::table('vmt_pms_rating')->insert([
            ['id'=>'1','score_range'=>'Less than 60', 'performance_rating' => 'Needs Action', 'ranking'=>'1', 'action' => 'Exit','sort_order' => '1'],
            ['id'=>'2','score_range'=>'61 - 70', 'performance_rating' => 'Below Expectations', 'ranking'=>'2', 'action' => 'PIP','sort_order' => '2'],
            ['id'=>'3','score_range'=>'71 - 80', 'performance_rating' => 'Meet Expectations', 'ranking'=>'3', 'action' => '10%','sort_order' => '3'],
            ['id'=>'4','score_range'=>'81 - 90', 'performance_rating' => 'Exceeds Expectations', 'ranking'=>'4', 'action' => '15%','sort_order' => '4'],
            ['id'=>'5','score_range'=>'91 - 100', 'performance_rating' => 'Exceptionally Exceeds Expectations', 'ranking'=>'5', 'action' => '20%','sort_order' => '5'],
        ]);
    }
}
