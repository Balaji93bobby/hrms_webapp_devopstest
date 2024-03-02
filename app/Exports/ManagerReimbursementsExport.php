<?php

namespace App\Exports;

use App\Models\VmtEmployeeReimbursements;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Protection;


class ManagerReimbursementsExport implements FromArray,ShouldAutoSize,WithHeadings,WithCustomStartCell,WithStyles,WithEvents,WithDrawings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $reimbursements_details;
    protected $totals;
    protected $legal_entity;
    protected $month_name;
    protected $year;
    protected $client_name;
    protected $total_row;
    function __construct($reimbursements_details,$totals,$legal_entity,$month_name,$year,$client_name){
        $this->reimbursements_details=$reimbursements_details;
        $this->totals=$totals;
        $this->total_row=count($this->reimbursements_details)+4;
        $this->legal_entity=$legal_entity;
        $this->month_name=$month_name;
        $this->year=$year;
        $this->client_name=$client_name;

    }


    public function headings():array
    {
        return[
            'Employee ID',
            'Employee Name',
            'Designation',
            'Department',
            'Total Travelled KM',
            'Amount',
            'Manager Name'
                 ];
     }

     public function startCell(): string
    {
        return 'A3';
    }

    public function registerEvents(): array
    {
        return [
            // AfterSheet::class    => function(AfterSheet $event) {
            //     $event->sheet->getDelegate()->getStyle('A3:G'.$this->total_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            // },
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(35);
            },
        ];
    }


    public function styles(Worksheet $sheet)
    {

        ///$sheet->getParent()->getActiveSheet()->getProtection()->setSheet(true);

        //For Remove Grid Lines
        $sheet->setShowGridlines(false);
        //For First Row
        $sheet->mergeCells('A1:D1')->setCellValue('A1', "Legal Entity : ".$this->legal_entity);
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        //For Second Row
        $sheet->mergeCells('A2:D2')->setCellValue('A2', "Month : ".$this->month_name.' - '.$this->year);
        $sheet->getStyle('A2:D2')->getFont()->setBold(true);
        $sheet->getStyle('A2:G2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        //Color and Font For 3rd Row
        $sheet->getStyle('A3:G3')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('002164');
        $sheet->getStyle('A3:G3')->getFont()->setBold(true)
                            ->getColor()->setRGB('ffffff');
        //For Logo
        $sheet->mergeCells('E1:G2');
        $sheet->getStyle('E1:G2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        //Color NAd Font For Last Row
        $sheet->mergeCells('A'.$this->total_row.':D'.$this->total_row)->setCellValue('A'.$this->total_row,$this->totals['Total']);
        $sheet->setCellValue('E'.$this->total_row,$this->totals['overall_distance']);
        $sheet->setCellValue('F'.$this->total_row,$this->totals['overall_Expense']);
        $sheet->getStyle('A'.$this->total_row.':G'.$this->total_row)->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('002164');
        $sheet->getStyle('A'.$this->total_row.':G'.$this->total_row)->getFont()->setBold(true)
        ->getColor()->setRGB('ffffff');

        $sheet->setCellValue('C'.($this->total_row+2), "Human Resource Manager Signature");
        $sheet->getStyle('C'.($this->total_row+2))->getFont()->setBold(true)->setUnderline(true);

        $sheet->mergeCells('E'.($this->total_row+2).':F'.($this->total_row+2))->setCellValue('E'.($this->total_row+2),"Finance Manager Signature");
        $sheet->getStyle('E'.($this->total_row+2))->getFont()->setBold(true)->setUnderline(true);

        //For Allignment Centre
        $sheet->getStyle('A3:G'.($this->total_row+2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

         //For Allignment Centre
         $sheet->getStyle('E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


       // $sheet->getStyle('A1:G'.($this->total_row+2))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THICK);

    }

    public function array(): array
    {

        return [
            $this->reimbursements_details,

        ];
    }


    //For LOGO Images INserting
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName($this->client_name);
        $drawing->setDescription($this->client_name);
        $drawing->setPath(public_path('assets/images/'.$this->client_name.'_logo.jpg'));
        $drawing->setHeight(60);
        $drawing->setWidth(65);
        $drawing->setCoordinates('F1');

        return $drawing;
    }


}
