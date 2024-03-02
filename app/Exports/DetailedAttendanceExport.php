<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class DetailedAttendanceExport implements FromArray, WithHeadings, ShouldAutoSize, WithCustomStartCell, WithStrictNullComparison, WithStyles,WithDrawings
{

    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    private $heading_dates;
    private $reportresponse;
    private $total_column;
    private $header_2;
    private $heading_dates_2;
    private $last_row;
    private $is_lc;
    private $public_client_logo_path;
    private $client_name;
    private $start_date;
    private $end_date;




    public function __construct($data, $is_lc,$client_name,$public_client_logo_path,$start_date, $end_date)
    {
        $this->heading_dates = $data['heading_dates'];
        $this->header_2 = $data['header_2'];
        $this->total_column = num2alpha(count($this->header_2) - 1);
        $this->reportresponse = $data['rows'];
        $this->heading_dates_2 = $data['heading_dates_2'];
        $this->last_row = count($this->reportresponse) + 8;
        $this->is_lc = $is_lc;
        $this->client_name = $client_name;
        $this->public_client_logo_path = $public_client_logo_path;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function headings(): array
    {
        return [
            $this->heading_dates,
            $this->header_2
        ];
    }

    public function startCell(): string
    {
        return 'A6';
    }


    public function styles(Worksheet $sheet)
    {

        $sheet->mergeCells('C1:E1')->setCellValue('C1', "Legal Entity : " .$this->client_name);
        $sheet->getStyle('C1:E1')->getFont()->setBold(true);

        $sheet->mergeCells('C2:E2')->setCellValue('C2', "Report Type : " .' Attedance Detailed Report');
        $sheet->getStyle('C2:E2')->getFont()->setBold(true);

        $sheet->mergeCells('C3:E3')->setCellValue('C3', "Period : ".Carbon::parse($this->start_date)->format('d-M-Y') .' to '. Carbon::parse($this->end_date)->format('d-M-Y'));
        $sheet->getStyle('C3:E3')->getFont()->setBold(true);


        // For First Four Column Headers
        for ($i = 0; $i < 4; $i++) {
            $sheet->mergeCells(num2alpha($i) . '6:' . num2alpha($i) . '7');
            $sheet->getStyle(num2alpha($i) . '6:' . num2alpha($i) . '7')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('002164');
            $sheet->getStyle(num2alpha($i) . '6')->getFont()->setBold(true)->getColor()->setRGB('ffffff');

            // $sheet->getStyle(num2alpha($i).'2:'.num2alpha($i).'3')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        }
        //$sheet->getStyle('A1:EI64')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        // Date Headings
        $i = 4;
        $j = 1;
        $k = 3;

        if ($this->is_lc) {
            $k = 4;
        }

        foreach ($this->heading_dates_2 as $single_date) {

            $sheet->mergeCells(num2alpha($i) . '6:' . num2alpha($i + $k) . '6')->setCellValue(num2alpha($i) . '6', $single_date);
            $sheet->getStyle(num2alpha($i) . '6:' . num2alpha($i + $k) . '6')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('002164');

            $sheet->getStyle(num2alpha($i) . '6:' . num2alpha($i + $k) . '6')
                ->getFont()->setBold(true)->getColor()->setRGB('ffffff');

            if ($j % 2 == 0) {
                $sheet->getStyle(num2alpha($i) . '7:' . num2alpha($i + $k) . '7')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('808080');
            } else {
                $sheet->getStyle(num2alpha($i) . '7:' . num2alpha($i + $k) . '7' )->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('BFBFBF');
            }

            $sheet->getStyle(num2alpha($i) . '7:' . num2alpha($i + $k) . '7')
                    ->getFont()->setBold(true)->getColor()->setRGB('ffffff');


            if ($this->is_lc) {
                $i = $i + 5;
            } else {
                $i = $i + 4;
            }
            $j = $j + 1;
        }

        $sheet->mergeCells(num2alpha($i+1) . '6:' . num2alpha($i + 11) . '6')->setCellValue(num2alpha($i) . '6', end($this->heading_dates));
        $sheet->getStyle(num2alpha($i) . '6:' . num2alpha($i + 12) . '6')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('002164');

        $sheet->getStyle(num2alpha($i) . '6:' . num2alpha($i + 12) . '6')
                    ->getFont()->setBold(true)->getColor()->setRGB('ffffff');

        $sheet->getStyle(num2alpha($i) . '7:' . num2alpha($i + 12) . '7' )->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('808080');

        $sheet->getStyle(num2alpha($i) . '7:' . num2alpha($i + 12) . '7')
                    ->getFont()->setBold(true)->getColor()->setRGB('ffffff');

        $sheet->mergeCells('A' . ($this->last_row) . ':D' . ($this->last_row))->setCellValue('A' . ($this->last_row), " This report is generated by ABShrms Payroll Software : " . Carbon::now()->format('d-M-Y'));
        $sheet->getStyle('A' . ($this->last_row))->getFont()->setBold(true);

        $sheet->setShowGridlines(false);

    }


    public function array(): array
    {
        $single_employee = array();


        for ($i = 0; $i < count($this->reportresponse); $i++) {
            array_push($single_employee, $this->reportresponse[$i]);
        }

        return  $single_employee;
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setPath($this->public_client_logo_path);
        $drawing->setHeight(1200);
        $drawing->setWidth(224);
        $drawing->setCoordinates('A1');
        return $drawing;
    }

}
