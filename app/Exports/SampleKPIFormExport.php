<?php

namespace App\Exports;
use App\Models\User;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SampleKPIFormExport implements FromArray, WithHeadings, WithStyles, WithEvents
{

    protected $selected_kpi_columns;

    public function __construct(array $t_selected_kpi_columns,$selectedYear)
    {
        $this->selected_year = $selectedYear;
        $this->selected_kpi_columns = $t_selected_kpi_columns;
    }

    public function headings():array{
        $firstTile = 'GREAT CONVERSATIONS - KPI Form (2018 - 2018)';
        if(isset($this->selected_year) && !empty($this->selected_year)){
            $firstTile = 'GREAT CONVERSATIONS - KPI Form ('.$this->selected_year.')';
        }
        $data = [
            $firstTile,
        ];
        $data1 = [
            'KPIs',
        ];
        return [$data,$data1];
    } 


    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
   
                $event->sheet->getDelegate()->getStyle('A1:A2')
                                ->getFont()
                                ->getColor()
                                ->setARGB('FFFFFFFF');


                $event->sheet->getDelegate()->getStyle(3)
                                ->getFont()
                                ->getColor()
                                ->setARGB('FFFFFFFF');


                $event->sheet->getDelegate()->getStyle('A1:A2')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                $event->sheet->getDelegate()->getStyle(3)
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
              
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
       
        $sheet->mergeCells('A1:P1');
        $sheet->mergeCells('A2:P2');

        $sheet->getStyle('A1')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => '002060'],]);
        $sheet->getStyle('A2')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => '366092'],]);
        $sheet->getStyle('A3:P3')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => '366092'],]);

    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return [
            [$this->selected_kpi_columns]

        ];
    }
}
