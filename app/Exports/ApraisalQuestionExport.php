<?php

namespace App\Exports;

use App\Models\VmtAppraisalQuestion;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ApraisalQuestionExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id;

    function __construct($id) {
        $this->id = $id;
    }

    public function headings():array{
        return[
            'Dimension',
            'kpi',
            'Operational Definition',
            'Measure',
            'Frequency',
            'Target',
            'Stretch Target',
            'Source',
            'KPI Weightage',
            'KPI-Achievement (Self Review)',
            'Self KPI Achievement %',
            'Comments',
        ];
    } 

    public function collection()
    {
        return VmtAppraisalQuestion::select('dimension', 'kpi', 'operational_definition', 'measure', 'frequency', 'target', 'stretch_target', 'source', 'kpi_weightage')->whereIn('id', explode(',', $this->id))->get();
    }
}
