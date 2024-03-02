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
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class AnnualEarnedExport implements FromArray,ShouldAutoSize,WithHeadings,WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $response;
    protected $headings;

    function __construct($response,$headings){
       $this->response= $response;
       $this->headings = $headings;
    }
    // public function headings():array{
    //     return[
    //         'Employee Id',
    //         'Employee Code',
    //         'Employee Name',
    //         'DOJ',
    //         'DOB',
    //         'Earned Basic',
    //         'Basic Arrear',
    //         'Earned HRA',
    //         'HRA Arrear',
    //         'Earned Child Education Allowance',
    //         'Earned Child Education Arrear',
    //         'Earned Special Allowance',
    //         'Special Allowance Arrear',
    //         'Overtime',
    //         'Total Earned Gross',
    //         'Pf Wages',
    //         'PF_WAGES_ARREAR_EPFR',
    //         'EPFR',
    //         'EPFR Arrear'
    //     ];


    // }



    public function headings():array
    {
        return [$this->headings];
    }
    public function array(): array{
        return [
            $this->response
        ];
    }


}
