<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use Maatwebsite\Excel\Concerns\FromQuery;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class QuickOnbaordSampleExport implements FromArray, ShouldAutoSize, WithHeadings, WithCustomStartCell, WithStyles, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $title;
    protected $client_list;
    protected $departments;
    protected $marital_status;
    protected $manager_code;
    protected $salary;
    function __construct($onbaord_details)
    {
        $this->title = $onbaord_details['title'];
        $this->client_list = $onbaord_details['client_list'];
        $this->departments = $onbaord_details['department'];
        $this->marital_status = $onbaord_details['marital_status'];
        $this->manager_code = $onbaord_details['managr_code'];
        $this->salary = $onbaord_details['salary'];
    }

    public function startCell(): string
    {
        return 'A1';
    }
    public function styles(Worksheet $sheet)
    {
        //For First Row
      //  $sheet->mergeCells('A1:T1')->setCellValue('A1', $this->title);
        $sheet->getStyle('A1:U1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('002060');
        $sheet->getStyle('A1:U1')->getFont()->setBold(true)->getColor()->setRGB('ffffff');
        $sheet->getStyle('A1:U1')->getAlignment()->setHorizontal('center');
    }

    public function headings(): array
    {
        return [
            'Employee Code',
            'Employee Name',
            'Official Email',
            'Mobile Number',
            'Gender',
            'Date Of Birth (dd-mmm-yyyy)',
            'Date of Joined (dd-mmm-yyyy)',
            'Legal Entity',
            'Department',
            'Designation',
            'Location',
            'Reporting Manager Employee Code',
            'Work Phone',
            'Personal Email',
            'Marital Status',
            'Father Name',
            'Physically Handicapped',
            'Pan Number',
            'Aadhaar Number',
            'Compensatory Type',
            'Amount',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function array(): array
    {

        return [
            [
                'ABS0001',
                'Name',
                'abs@gmail.com',
                '0912345678',
                'Male',
                '28-06-2000',
                '14-11-2022',
                '',
                'It',
                '',
                'Chennai',
                'ABSM001',
                '0912345678',
                'test@gmail.com',
                'Single',
                'Father Name',
                'No',
                'ABCTY1234D',
                '0000 1111 2222',
                '',
                '18000'

            ]
        ];
    }


    public function registerEvents(): array
    {
        return [
            // handle by a closure.
            AfterSheet::class => function (AfterSheet $event) {

                //get layout counts (add 1 to rows for heading row)
                // $row_count = $this->results->count() + 1;
                // $column_count = count($this->results[0]->toArray());
                $row_count = 10;
                $column_count = 0;

                // set dropdown column
                $gender_column = 'E';
                $legal_entity_column = 'H';
                $departments_column = 'I';
                $marital_column = 'O';
                $compansation_column = 'T';
                $manager_code_column = 'L';
                $mobile_num_column = 'D';

                // set dropdown options
                $gender_options = [
                    'Male',
                    'Female',
                ];
                $legal_entity_option =   $this->client_list;
                $departments_option = $this->departments;
                $marital_option = $this->marital_status;
                $manager_code_option = $this->manager_code;

                // set dropdown list for Gender
                $validation_gender = $event->sheet->getCell("{$gender_column}3")->getDataValidation();
                $validation_gender->setType(DataValidation::TYPE_LIST);
                $validation_gender->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation_gender->setAllowBlank(false);
                $validation_gender->setShowInputMessage(true);
                $validation_gender->setShowErrorMessage(true);
                $validation_gender->setShowDropDown(true);
                $validation_gender->setErrorTitle('Input error');
                $validation_gender->setError('Value is not in list.');
                $validation_gender->setPromptTitle('Pick from list');
                $validation_gender->setPrompt('Please pick a value from the drop-down list.');
                $validation_gender->setFormula1(sprintf('"%s"', implode(',',  $gender_options)));

                // set dropdown list for Legal Entity
                $validation_entity = $event->sheet->getCell("{$legal_entity_column}3")->getDataValidation();
                $validation_entity->setType(DataValidation::TYPE_LIST);
                $validation_entity->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation_entity->setAllowBlank(false);
                $validation_entity->setShowInputMessage(true);
                $validation_entity->setShowErrorMessage(true);
                $validation_entity->setShowDropDown(true);
                $validation_entity->setErrorTitle('Input error');
                $validation_entity->setError('Selected Legal Entity is not in list.');
                $validation_entity->setPromptTitle('Select Legal Entity from list');
                $validation_entity->setPrompt('Please pick a value from the drop-down list.');
                $validation_entity->setFormula1($legal_entity_option);

                // set dropdown list for Legal Entity
                // $validation_dep = $event->sheet->getCell("{$departments_column}3")->getDataValidation();
                // $validation_dep->setType(DataValidation::TYPE_LIST);
                // $validation_dep->setErrorStyle(DataValidation::STYLE_INFORMATION);
                // $validation_dep->setAllowBlank(false);
                // $validation_dep->setShowInputMessage(true);
                // $validation_dep->setShowErrorMessage(true);
                // $validation_dep->setShowDropDown(true);
                // $validation_dep->setErrorTitle('Input error');
                // $validation_dep->setError('Selected Department is not in list.');
                // $validation_dep->setPromptTitle('Select Department from list');
                // $validation_dep->setPrompt('Please pick a Department from the drop-down list.');
                // $validation_dep->setFormula1($departments_option);

                //set dropdown list for marital status
                $validation_mar_sts = $event->sheet->getCell("{$marital_column}3")->getDataValidation();
                $validation_mar_sts->setType(DataValidation::TYPE_LIST);
                $validation_mar_sts->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation_mar_sts->setAllowBlank(false);
                $validation_mar_sts->setShowInputMessage(true);
                $validation_mar_sts->setShowErrorMessage(true);
                $validation_mar_sts->setShowDropDown(true);
                $validation_mar_sts->setErrorTitle('Input error');
                $validation_mar_sts->setError('Selected Option is not in list.');
                $validation_mar_sts->setPromptTitle('Select Marital Status from list');
                $validation_mar_sts->setPrompt('Please pick a  Marital Status from the drop-down list.');
                $validation_mar_sts->setFormula1($marital_option);

                //set dropdown list for managercode
                // $validation_mangr_code = $event->sheet->getCell("{$manager_code_column}3")->getDataValidation();
                // $validation_mangr_code->setType(DataValidation::TYPE_LIST);
                // $validation_mangr_code->setErrorStyle(DataValidation::STYLE_WARNING);
                // $validation_mangr_code->setAllowBlank(false);
                // $validation_mangr_code->setShowInputMessage(true);
                // $validation_mangr_code->setShowErrorMessage(true);
                // $validation_mangr_code->setShowDropDown(true);
                // $validation_mangr_code->setErrorTitle('Input error');
                // $validation_mangr_code->setError('Selected Option is not in list.');
                // $validation_mangr_code->setPromptTitle('Select Manager Code from list');
                // $validation_mangr_code->setPrompt('Please pick a  Manager Code from the drop-down list.');
                // $validation_mangr_code->setFormula1($manager_code_option);

                
                //set dropdown list for CompansationType
                $validation_compansation = $event->sheet->getCell("{$compansation_column}3")->getDataValidation();
                $validation_compansation->setType(DataValidation::TYPE_LIST);
                $validation_compansation->setErrorStyle(DataValidation::STYLE_WARNING);
                $validation_compansation->setAllowBlank(false);
                $validation_compansation->setShowInputMessage(true);
                $validation_compansation->setShowErrorMessage(true);
                $validation_compansation->setShowDropDown(true);
                $validation_compansation->setErrorTitle('Input error');
                $validation_compansation->setError('Selected Option is not in list.');
                $validation_compansation->setPromptTitle('Select Compansation Type  from list');
                $validation_compansation->setPrompt('Please pick a  Compansation Type from the drop-down list.');
                $validation_compansation->setFormula1('"CTC - Monthly,GROSS - Monthly,TAKE HOME - Monthly"');

                //set dropdown list for handicapped column
                $validation_Q = $event->sheet->getCell("Q3")->getDataValidation();
                $validation_Q->setType(DataValidation::TYPE_LIST);
                $validation_Q->setErrorStyle(DataValidation::STYLE_WARNING);
                $validation_Q->setAllowBlank(false);
                $validation_Q->setShowInputMessage(true);
                $validation_Q->setShowErrorMessage(true);
                $validation_Q->setShowDropDown(true);
                $validation_Q->setErrorTitle('Input error');
               //$validation_compansation->setError('Selected Option is not in list.');
               // $validation_compansation->setPromptTitle('Select Compansation Type  from list');
               // $validation_compansation->setPrompt('Please pick a  Compansation Type from the drop-down list.');
               $validation_Q->setFormula1('"Yes,No"');

                //validation For Mobile Number
                // $validation_mobile = $event->sheet->getCell("{$mobile_num_column}3")->getDataValidation();
                // $validation_mobile->setType(DataValidation::TYPE_WHOLE);
                // $validation_mobile->setErrorStyle(DataValidation::STYLE_STOP);
                // $validation_mobile->setAllowBlank(true);
                // $validation_mobile->setShowInputMessage(true);
                // $validation_mobile->setShowErrorMessage(true);
                // $validation_mobile->setErrorTitle('Input error');
                // $validation_mobile->setError('invalid Mobile Number!');
                // $validation_mobile->setPromptTitle('Allowed input');
                // $validation_mobile->setPrompt('Only 10 Digits Are Allowed');
                // $validation_mobile->setFormula1(10);
                // $validation_mobile->setFormula2(12);

                //clone validation to remaining rows
                for ($i = 3; $i <= $row_count; $i++) {
                    $event->sheet->getCell("{$gender_column}{$i}")->setDataValidation(clone  $validation_gender);
                    $event->sheet->getCell("{$legal_entity_column}{$i}")->setDataValidation(clone    $validation_entity);
                  //  $event->sheet->getCell("{$departments_column}{$i}")->setDataValidation(clone   $validation_dep);
                    $event->sheet->getCell("{$marital_column}{$i}")->setDataValidation(clone  $validation_mar_sts);
                 //   $event->sheet->getCell("{$manager_code_column}{$i}")->setDataValidation(clone   $validation_mangr_code);
                    $event->sheet->getCell("{$compansation_column}{$i}")->setDataValidation(clone    $validation_compansation);
                    $event->sheet->getCell("Q{$i}")->setDataValidation(clone    $validation_Q);
                    //$event->sheet->getCell("{$mobile_num_column}{$i}")->setDataValidation(clone    $validation_mobile);
                }

                // set columns to autosize
                for ($i = 1; $i <= $column_count; $i++) {
                    $column = Coordinate::stringFromColumnIndex($i);
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },

        ];
    }
}
