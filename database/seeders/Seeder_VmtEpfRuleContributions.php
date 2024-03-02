<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Seeder_VmtEpfRuleContributions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('vmt_payroll_epf_calculation')->truncate();

        $epf_cal_basedon_gross_1 = [["operand"=> 'gross', "operator"=> " "], ["operand"=>"hra" , "operator"=> "-"], ["operand"=>0.12,"operator"=> "*"]];
        $epf_cal_basedon_gross_2 = [["operand"=> 'gross', "operator"=> " "], ["operand"=>"hra", "operator"=> "-"], ["operand"=> 0.1,"operator"=> "*"]];
        $epf_cal_basedon_gross_3 = [["operand"=> 'gross', "operator"=> " "], ["operand"=>"hra", "operator"=> "-"], ["operand"=>15000 , "operator"=> ">"], ["operand"=> 0.12,"operator"=> "*"]];
        $epf_cal_basedon_gross_4 = [["operand"=> 'gross', "operator"=> " "], ["operand"=>"hra", "operator"=> "-"], ["operand"=>15000 , "operator"=> ">"], ["operand"=> 0.1,"operator"=> "*"]];
        $epf_cal_basedon_basic_1 = [["operand"=> 'basic', "operator"=> " "], ["operand"=>"vda" , "operator"=> "+"], ["operand"=>0.12,"operator"=> "*"]];
        $epf_cal_basedon_basic_2 = [["operand"=> 'basic', "operator"=> " "], ["operand"=>"vda" , "operator"=> "+"], ["operand"=>0.1,"operator"=> "*"]];
        $epf_cal_basedon_basic_3 = [["operand"=> 'basic', "operator"=> " "], ["operand"=>"vda", "operator"=> "+"], ["operand"=>15000 , "operator"=> ">"], ["operand"=> 0.12,"operator"=> "*"]];
        $epf_cal_basedon_basic_4 = [["operand"=> 'basic', "operator"=> " "], ["operand"=>"vda", "operator"=> "+"], ["operand"=>15000 , "operator"=> ">"], ["operand"=> 0.1,"operator"=> "*"]];


        DB::table('vmt_payroll_epf_calculation')->insert([
            ['id'=>'1','epf_rule'=>'Gross Earning (-) HRA 12% ','epf_contribution_type'=>'Gross (-) HRA (*) 12% ',"epf_calculation_json"=>json_encode($epf_cal_basedon_gross_1)],
            ['id'=>'2','epf_rule'=>'Gross Earning (-) HRA > 15000 *12%','epf_contribution_type'=>'15000*12%',"epf_calculation_json"=>json_encode($epf_cal_basedon_gross_2)],
            ['id'=>'3','epf_rule'=>'Gross Earning (-) HRA 10%','epf_contribution_type'=>'Gross (-) HRA (*) 10%',"epf_calculation_json"=>json_encode($epf_cal_basedon_gross_3)],
            ['id'=>'4','epf_rule'=>'Gross Earning (-) HRA > 15000 *10%','epf_contribution_type'=>'15000*10%',"epf_calculation_json"=>json_encode($epf_cal_basedon_gross_4)],
            ['id'=>'5','epf_rule'=>'Basic (+) VDA 12%','epf_contribution_type'=>'Basic (+) VDA (*) 10%',"epf_calculation_json"=>json_encode($epf_cal_basedon_basic_1)],
            ['id'=>'6','epf_rule'=>'Basic (+) VDA > 15000 *12%','epf_contribution_type'=>'15000*12%',"epf_calculation_json"=>json_encode($epf_cal_basedon_basic_2)],
            ['id'=>'7','epf_rule'=>'Basic (+) VDA 10%','epf_contribution_type'=>'Basic (+) VDA (*) 10%',"epf_calculation_json"=>json_encode($epf_cal_basedon_basic_3)],
            ['id'=>'8','epf_rule'=>'Basic (+) VDA > 15000 *10%','epf_contribution_type'=>'15000*10%',"epf_calculation_json"=>json_encode($epf_cal_basedon_basic_4)],

        ]);

    }
}
