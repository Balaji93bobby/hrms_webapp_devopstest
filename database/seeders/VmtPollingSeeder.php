<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VmtPollingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('polling_questions')->insert([
            ['question' => 'Which place do you want to go for a Vacation?', 'options' => '["Ooty", "Magalaya", "Kanyakumari"]', 'created_at' => date("Y-m-d")],
        ]);
    }
}
