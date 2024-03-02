<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfigPms;
use App\Models\VmtPMSRating;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Session as Ses;

class ConfigPmsController extends Controller
{
    public function index(Request $request) {

        $this->checkConfigPms();

        $data = ConfigPms::first();
        $config_data = VmtPMSRating::all();

        if ($data) {
            $data->header = json_decode($data->column_header, true);
        }

        return view('vmt_config_pms', compact('data','config_data'));
    }

    public function store(Request $request) {

        //dd($request->all());

        $json = json_encode([
            'dimension' => $request->input('dimension') != '' ? $request->input('dimension') : 'Dimension',
            'kpi' => $request->input('kpi') != '' ? $request->input('kpi') : 'KPI',
            'operational' => $request->input('operational') != '' ? $request->input('operational') : 'Operational Definition',
            'measure' => $request->input('measure') != '' ? $request->input('measure') : 'Measure',
            'frequency' => $request->input('frequency') != '' ? $request->input('frequency') : 'Frequency',
            'target' => $request->input('target') != '' ? $request->input('target') : 'Target',
            'stretchTarget' => $request->input('stretchTarget') != '' ? $request->input('stretchTarget') : 'Stretch Target',
            'source' => $request->input('source') != '' ? $request->input('source') : 'Source',
            'kpi_weightage' => $request->input('kpiWeightage') != '' ? $request->input('kpiWeightage') : 'KPI Weightage ( % )',
        ]);
        $selectedColumn = [];
        if ($request->input('dimension_check')) {
            array_push($selectedColumn, 'dimension');
        }
        if ($request->input('kpi_check')) {
            array_push($selectedColumn, 'kpi');
        }
        if ($request->input('operational_check')) {
            array_push($selectedColumn, 'operational_definition');
        }
        if ($request->input('measure_check')) {
            array_push($selectedColumn, 'measure');
        }
        if ($request->input('frequency_check')) {
            array_push($selectedColumn, 'frequency');
        }
        if ($request->input('target_check')) {
            array_push($selectedColumn, 'target');
        }
        if ($request->input('stretchTarget_check')) {
            array_push($selectedColumn, 'stretch_target');
        }
        if ($request->input('source_check')) {
            array_push($selectedColumn, 'source');
        }
        if ($request->input('kpiWeightage_check')) {
            array_push($selectedColumn, 'kpi_weightage');
        }

        $config = ConfigPms::first();

        //dd( $request->all());

        $config->calendar_type = $request->calendar_type;
        $config->year = $request->year;
        $config->frequency = $request->selected_frequency;
        $config->assignment_period = $request->assignment_period_start;

        //score card ui related
        $config->can_show_ratingcard_in_reviewpage = $request->input('radiobtn_show_ratingcard');
        $config->can_show_overallscorecard_in_reviewpage = $request->input('radiobtn_show_overallscorecard_in_reviewpage');
        $config->can_show_overallscorecard_in_selfappraisal_dashboard = $request->input('radiobtn_show_overallscorecard_in_selfappraisaldashboard');

        $config->selected_columns = implode(',',$selectedColumn);
        $config->selected_head = $request->input('selected_head');
        $config->selected_reviewlevel = $request->input('selected_reviewlevels');
        $config->column_header = $json;
        $config->user_id = auth()->user()->id;
        $config->save();

        //Store the PMS Rating


        return redirect()->back();
    }


    /*
        Called In PMS Dashboard
    */
    public static function checkConfigPms(){

        $config = ConfigPms::first();

        if (!$config)
        {
            $createConfig = new ConfigPms;
            $createConfig->selected_columns = "dimension,kpi,operational,measure,frequency,target,stretchTarget,source,kpiWeightage";
            $createConfig->selected_head = "hr";
            $createConfig->column_header = '{"dimension":null,"kpi":null,"operational":null,"measure":null,"frequency":null,"target":null,"stretchTarget":null,"source":null,"kpiWeightage":null}';
            $createConfig->user_id = auth()->user()->id;
            $createConfig->save();
        }

    }
   // protected $fillabel = ['$request->name','$request->value'];


    public function storePMSRating(Request $request)
    {
       // dd($request->name .$request->value . $request->pk);
        if ($request->ajax()) {

            // VmtPMSRating::find($request->pk)

            //     ->update([

            //         $request->name => $request->value

            //     ]);
            DB::table('vmt_pms_rating')->where('id', $request->pk)->update(array($request->name => $request->value));


            return response()->json(['success' => true]);

        }
       // DB::table('vmt_pms_rating')->insert([

    }

    public function getPMSRating(Request $request)
    {
        return VmtPMSRating::all();

    }
}
