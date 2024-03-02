<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;

class PMSScoreExport implements FromArray,ShouldAutoSize,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $response;

    function __construct($response){
       $this->response= $response;
    }

    public function headings():array{
        return[
            'Employee Code',
            'Employee Name',
            'Calendar Type',
            'Year',
            'Assignment Period',
            'Employee Kpi Percentage',
            'Manager Kpi Percentage',
            'Manager Name'
        ];
    }

    public function array(): array{
        return [
            $this->response
        ];
    }



}
