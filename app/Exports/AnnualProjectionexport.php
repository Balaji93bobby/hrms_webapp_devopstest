<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithTitle;

class AnnualProjectionexport implements FromArray,ShouldAutoSize, WithHeadings, WithCustomStartCell, WithStyles,WithEvents,WithStrictNullComparison,WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */

      protected $data;

      private $heading_dates;
      private $reportresponse;

    public function __construct($data)
    {

        $this->headings=$data[0];
        $this->total_column = num2alpha(count($data[0])-1);
        $this->reportresponse=$data[1];
        $this->title=$data[2];
    }

    public function headings():array{
        return [$this->headings];
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function title(): string
    {
        return $this->title;
    }

    public function styles(Worksheet $sheet)
    {
        //For First Row
        // $sheet->mergeCells('A1:AF1')->setCellValue('A1', $this->title);
        $sheet->getStyle('A1:'.$this->total_column.'1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('002060');
        $sheet->getStyle('A1:'.$this->total_column.'1')->getFont()->setBold(true)->getColor()->setRGB('ffffff');
        $sheet->getStyle('A1:'.$this->total_column.'1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:'.$this->total_column.'1')->getAlignment()->setWrapText(true);

    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;
                // $sheet->getParent()->getActiveSheet()->getProtection()->setSheet(true);
                // $sheet->getParent()->getActiveSheet()->getProtection()->setPassword('Abs@123');
                // $styleArray = [
                //     'alignment' => [
                //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                //     ],

                // ];
                // $cellRange = 'A2:'.$this->total_column.'2'; // All headers
                // $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);


            },
        ];
    }

    public function array(): array
    {
        return [$this->reportresponse];
    }

}
