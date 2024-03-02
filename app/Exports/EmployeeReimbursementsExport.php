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
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use Maatwebsite\Excel\Concerns\FromQuery;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;

class EmployeeReimbursementsExport implements FromArray,ShouldAutoSize,WithHeadings,WithCustomStartCell,WithStyles,WithEvents,WithDrawings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $reimbursements_details;
    protected $legal_entity;
    protected $totals;
    protected $month_name;
    protected $year;
    protected $client_name;
    protected $client_logo_path;
    protected $employee_details;
    protected $total_row;

    function __construct($employee_details,$reimbursement_data,$legal_entity,$month_name,$year,$client_name, $client_logo_path,$totals){
        $this->employee_details = $employee_details;
        $this->reimbursements_details = $reimbursement_data;
        $this->legal_entity = $legal_entity;
        $this->month_name = $month_name;
        $this->year = $year;
        $this->client_name = $client_name;
        $this->client_logo_path = $client_logo_path;
        $this->totals=$totals;
        $this->total_row=count($this->reimbursements_details)+6;
    }

    public function headings():array
    {
        return[
            'Date',
            'Reimbursement Header',
            'From Place',
            'To Place',
            'Mode Of Travel',
            'Total Travelled KM',
            'Amount / KM',
            'Amount',
            'Remarks'
                 ];
     }

     public function startCell(): string
    {
        return 'A5';
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

    // public static function beforeSheet(BeforeSheet $event)
    // {
    //      $event->sheet->getActiveSheet()->getPageSetup()
    //            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //      $event->sheet->getActiveSheet()->getPageSetup()
    //            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
    //      $event->$sheet->setPageMargin(0);
    // }

    public function styles(Worksheet $sheet)
    {
        $sheet->getParent()->getActiveSheet()->getPageSetup()->setpaperSize(1);
        $sheet->getParent()->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getParent()->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A3);

        ///$sheet->getParent()->getActiveSheet()->getProtection()->setSheet(true);

        //For Remove Grid Lines
        $sheet->setShowGridlines(false);

        //For First Row
        $sheet->mergeCells('A1:D1')->setCellValue('A1', "Legal Entity : ".$this->legal_entity);
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        //For Second Row
        $sheet->mergeCells('A2:D2')->setCellValue('A2', "Month : ".$this->month_name.' - '.$this->year);
        $sheet->getStyle('A2:D2')->getFont()->setBold(true);
        $sheet->getStyle('A2:I2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        //For Third Row
        $sheet->mergeCells('A3:B3')->setCellValue('A3','Employee ID',);
        $sheet->mergeCells('C3:D3')->setCellValue('C3','Employee Name');
        $sheet->mergeCells('E3:F3')->setCellValue('E3','Department');
        $sheet->mergeCells('G3:I3')->setCellValue('G3','Location');
        $sheet->getStyle('A3:I3')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('002164');
        $sheet->getStyle('A3:I3')->getFont()->setBold(true)
        ->getColor()->setRGB('ffffff');

        //For Fourth Row
        $sheet->mergeCells('A4:B4')->setCellValue('A4',$this->employee_details['user_code']);
        $sheet->mergeCells('C4:D4')->setCellValue('C4',$this->employee_details['name']);
        $sheet->mergeCells('E4:F4')->setCellValue('E4',$this->employee_details['department']);
        $sheet->mergeCells('G4:I4')->setCellValue('G4',$this->employee_details['location']);
        $sheet->getStyle('A4:I4')->getFont()->setBold(true);


        //Color and Font For 5th Row
        $sheet->getStyle('A5:I5')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('002164');
        $sheet->getStyle('A5:I5')->getFont()->setBold(true)
                            ->getColor()->setRGB('ffffff');
        //For Logo
        $sheet->mergeCells('G1:I2');
        $sheet->getStyle('G1:I2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        //Color and  Font For Last Row
        $sheet->mergeCells('A'.$this->total_row.':D'.$this->total_row)->setCellValue('A'.$this->total_row,$this->totals['Total']);
        $sheet->setCellValue('F'.$this->total_row,$this->totals['overall_distance']);
        $sheet->setCellValue('H'.$this->total_row,$this->totals['overall_Expense']);
        $sheet->getStyle('A'.$this->total_row.':I'.$this->total_row)->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setRGB('002164');
        $sheet->getStyle('A'.$this->total_row.':I'.$this->total_row)->getFont()->setBold(true)
        ->getColor()->setRGB('ffffff');

        $sheet->setCellValue('D'.($this->total_row+2), "Human Resource Manager Signature");
        $sheet->getStyle('D'.($this->total_row+2))->getFont()->setBold(true)->setUnderline(true);

        $sheet->mergeCells('F'.($this->total_row+2).':G'.($this->total_row+2))->setCellValue('F'.($this->total_row+2),"Finance Manager Signature");
        $sheet->getStyle('F'.($this->total_row+2))->getFont()->setBold(true)->setUnderline(true);

        //For Allignment Centre
        $sheet->getStyle('A3:I'.($this->total_row+2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

         //For Allignment Centre
         $sheet->getStyle('E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

         // For Can not edit sheet without unprortect sheet without password
         $sheet->getParent()->getActiveSheet()->getProtection()->setSheet(true);
         $sheet->getParent()->getActiveSheet()->getProtection()->setPassword('Abs@123');
         $sheet->getParent()->getActiveSheet()->getProtection()->setSort(true);
         $sheet->getParent()->getActiveSheet()->getProtection()->setInsertRows(true);
         $sheet->getParent()->getActiveSheet()->getProtection()->setFormatCells(true);
         $sheet->getParent()->getSecurity()->setLockWindows(true);
         $sheet->getParent()->getSecurity()->setLockStructure(true);
         $sheet->getParent()->getSecurity()->setWorkbookPassword("Abs@123");

         // Text Wrapping
        //  $sheet->getStyle('I19')->getAlignment()->setWrapText(true);

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
          $drawing->setPath(public_path($this->client_logo_path));
          $drawing->setHeight(1200);
          $drawing->setWidth(275);
          $drawing->setCoordinates('G1');

          return $drawing;
      }




}
