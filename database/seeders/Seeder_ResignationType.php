<?php

namespace Database\Seeders;

use App\Models\ResignationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Seeder_ResignationType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('vmt_resignation_type')->truncate();
        $reason_type = ['Better Prospect', 'Marriage and Relocating', 'Illness', 'Termination', 'Others'];
        foreach ($reason_type as $single_reason_type) {
            if (!ResignationType::where('reason_type', $single_reason_type)->exists())
                ResignationType::insert(['reason_type' => $single_reason_type]);
        }
    }
}
