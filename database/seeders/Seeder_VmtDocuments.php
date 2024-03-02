<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Seeder_VmtDocuments extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vmt_documents')->truncate();

        DB::table('vmt_documents')->insert([
            ['id'=>'1','document_name'=>'Aadhar Card Front','is_onboarding_doc'=>'0','is_mandatory'=>'1'],
            ['id'=>'2','document_name'=>'Aadhar Card Back','is_onboarding_doc'=>'0','is_mandatory'=>'1'],
            ['id'=>'3','document_name'=>'Pan Card','is_onboarding_doc'=>'0','is_mandatory'=>'1'],
            ['id'=>'4','document_name'=>'Passport','is_onboarding_doc'=>'0','is_mandatory'=>'1'],
            ['id'=>'5','document_name'=>'Voter ID','is_onboarding_doc'=>'0','is_mandatory'=>'1'],
            ['id'=>'6','document_name'=>'Driving License','is_onboarding_doc'=>'0','is_mandatory'=>'0'],
            ['id'=>'7','document_name'=>'Education Certificate','is_onboarding_doc'=>'0','is_mandatory'=>'0'],
            ['id'=>'8','document_name'=>'Relieving Letter','is_onboarding_doc'=>'0','is_mandatory'=>'0'],
            ['id'=>'9','document_name'=>'Birth Certificate','is_onboarding_doc'=>'1','is_mandatory'=>'0'],
            ['id'=>'10','document_name'=>'Cheque leaf/Bank Passbook','is_onboarding_doc'=>'0','is_mandatory'=>'1'],

        ]);
    }
}
