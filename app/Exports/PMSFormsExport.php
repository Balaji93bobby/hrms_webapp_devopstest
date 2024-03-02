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

class PMSFormsExport implements FromArray,WithHeadings,ShouldAutoSize,WithStyles,WithColumnWidths
{

    /**
    * @return \Illuminate\Support\Collection
    */

    protected $form_name;
    protected $headings;
    protected $form;

    protected $end_column;

    function __construct( $form_name,$headings,$form,$end_column){
      $this->form_name =  $form_name;
      $this->headings = $headings;
      $this->form  = $form;
      $this->end_column = $end_column;
      $this->total_row = count( $this->form )+1;
    }

    public function headings():array
    {
        return $this->headings;
    }

    public function array(): array
    {
        return [
            $this->form
        ];
    }

    public function columnWidths(): array{
        return[
            'A' => 81 ,
        ];
    }

    public function styles(Worksheet $sheet){

        // For First Row
        $sheet->getStyle('A1:'.$this->end_column.'1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('002164');
        $sheet->getStyle('A1:'.$this->end_column.'1')->getFont()->setBold(true)
        ->getColor()->setRGB('ffffff');

         //For Allignment Centre
         $sheet->getStyle('A1:'.$this->end_column.$this->total_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A1:D34')->getAlignment()->setWrapText(true);
    }
}
