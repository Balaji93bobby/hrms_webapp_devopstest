<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VmtPmsV3DefaultSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vmt_default_configs_v3')->truncate();

        DB::table('vmt_default_configs_v3')->insert([
            ['id'=>'1','config_name' => 'pms_default_ratings','config_value' =>'[{"score_range":"0-54","performance_rating":"Not meet the Expectation","ranking":"5","action":"PIP","sort_order":1},{"score_range":"55-74","performance_rating":"Below Expectation","ranking":"4","action":"7","sort_order":2},{"score_range":"75-84","performance_rating":"Meet Expectation","ranking":"3","action":"10","sort_order":3},{"score_range":"85-94","performance_rating":"Exceed Expectation","ranking":"2","action":"12","sort_order":4},{"score_range":"95-100","performance_rating":"Exceptionally Exceed Expectation","ranking":"1","action":"15","sort_order":5}]'],
            ['id'=>'2','config_name' => 'pms_default_form_headers','config_value' =>'[{"header_name":"dimension","header_label":"Dimension","alias_name":"","is_selected":"1"},{"header_name":"frequency","header_label":"Frequency","alias_name":"","is_selected":"1"},{"header_name":"operational_system","header_label":"Operational System","alias_name":"","is_selected":"1"},{"header_name":"stretch_target","header_label":"Stretch Target","alias_name":"","is_selected":"1"},{"header_name":"kpi_weightage","header_label":"KPI Weightage","alias_name":"","is_selected":"1"},{"header_name":"kpi_okr","header_label":"KPI/OKR","alias_name":"","is_selected":"1"},{"header_name":"measure","header_label":"Measure","alias_name":"","is_selected":"1"},{"header_name":"target","header_label":"Target","alias_name":"","is_selected":"1"},{"header_name":"source","header_label":"Source","alias_name":"","is_selected":"1"},{"header_name":"metrics","header_label":"Metrics","alias_name":"","is_selected":"1"}]']
        ]);
    }
}
