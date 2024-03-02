<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\NamedRange;
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
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class BulkOnbaordSampleExport implements  ShouldAutoSize, WithHeadings, WithCustomStartCell, WithStyles, WithEvents, WithMapping , WithCalculatedFormulas,WithMultipleSheets
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
    protected $blood_grp;
    function __construct($onbaord_details)
    {
        $this->title = $onbaord_details['title'];
        $this->client_list = $onbaord_details['client_list'];
        $this->departments = $onbaord_details['department'];
        $this->marital_status = $onbaord_details['marital_status'];
        $this->manager_code = $onbaord_details['managr_code'];
        $this->salary = $onbaord_details['salary'];
        $this->blood_grp = $onbaord_details['blood_group'];
    }

    public function startCell(): string
    {
        return 'A1';
    }
    public function styles(Worksheet $sheet)
    {
        //For First Row
        // $sheet->mergeCells('A1:AF1')->setCellValue('A1', $this->title);
        $sheet->getStyle('A1:BH1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('002060');
        $sheet->getStyle('A1:BH1')->getFont()->setBold(true)->getColor()->setRGB('ffffff');
        $sheet->getStyle('A1:BH1')->getAlignment()->setHorizontal('center');
    }
    // public function title(): string
    // {
    //     return 'Sheet1';
    // }


    public function sheets(): array
    {
        return [
            'Sheet 1' => $this,
            //'DropdownList' => new DropdownListSheet(),
        ];
    }

    public function headings(): array
    {
        return [
            'Employee Code',
            'Employee Name',
            'Official mail',
            'Mobile Number',
            'Gender',
            'Date Of Birth (dd-mmm-yyyy)',
            'Date of Joined (dd-mmm-yyyy)',
            'Legal Entity',
            'Department',
            'Designation',
            'Location',
            'Reporting Manager Employee Code',
            'Official Mobile',
            'Email',
            'Marital Status',
            'Marriage Date (dd-mmm-yyyy)',
            'Father Name',
            'Mother Name',
            'Spouse Name',
            'Blood Group',
            'Salary Payment Mode',
            'Physically Handicapped',
            'Pan Number',
            'Aadhaar Number',
            'Bank Name',
            'IFSC Code',
            'Bank Account Number',
            'Prev UAN',
            'ESI Eligible',
            'Prev ESI Number',
            'Basic',
            'HRA',
            'Dearness Allowance',
            'VDA',
            'Child Education Allowance',
            'Communication Allowance',
            'Food Allowance',
            'Travel Reimbursement (LTA)',
            'Special Allowance',
            'Other Allowance',
            'Vehicle Reimbursement',
            'Driver Salary',
            'Washing Allowance',
            'Unifrom Allowance',
            'Total Fixed Gross',
            'Employer EPF',
            'Employer ESIC',
            'Employer LWF',
            'Employer Insurance',
            'Cost to Company (CTC)',
            'Employee EPF',
            'Employee ESIC',
            'Professional Tax',
            'Employee LWF',
            'Employee Insurance',
            'Net Take Home',
            'Current Address',
            'Permanent Address',
        ];
    }

    public function title(): string
    {
        return 'Main Sheet';
    }
    public function sheets(): array
    {
        $sheets = [];

        // Create new sheet instances and add them to the $sheets array
        $sheets[] = new sheet();
        $sheets[] = new sheet1();

        return $sheets;
    }


    public function map($row): array
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
            '',
            'Father Name',
            'Mother Name',
            'Spouse Name',
            'B Positive',
            'No',
            'ABCTY1234D',
            '0000 1111 2222',
            'Axis Bank',
            'AXIB0028901',
            '24898240942',
            'UAN0945049',
            'Yes',
            '942904',
            'Current Address',
            'Permanent Address',
            'CTC - Monthly',
            '18000',
            '=(AG2*50)/100',
            '=(AH2*50)/100',
            '',
            '',
            '',
            '',
            '=AH2-AI2',

        ],
            ['','=AG2*10']
        ];
    }


    public function title(): string
    {
        return 'Main Sheet';
    }
    public function sheets(): array
    {
        $sheets = [];

        // Create new sheet instances and add them to the $sheets array
        $sheets[] = new sheet();
        $sheets[] = new sheet1();

        return $sheets;
    }


    public function map($row): array
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
            '',
            'Father Name',
            'Mother Name',
            'Spouse Name',
            'B Positive',
            'No',
            'ABCTY1234D',
            '0000 1111 2222',
            'Axis Bank',
            'AXIB0028901',
            '24898240942',
            'UAN0945049',
            'Yes',
            '942904',
            'Current Address',
            'Permanent Address',
            'CTC - Monthly',
            '18000',
            '=(AG2*50)/100',
            '=(AH2*50)/100',
            '',
            '',
            '',
            '',
            '=AH2-AI2',

        ],
            ['','=AG2*10']
        ];
    }


    // public function map($row): array
    // {
    //     return [
    //         [
    //         'ABS0001',
    //         'Name',
    //         'abs@gmail.com',
    //         '0912345678',
    //         'Male',
    //         '28-06-2000',
    //         '14-11-2022',
    //         '',
    //         'It',
    //         '',
    //         'Chennai',
    //         'ABSM001',
    //         '0912345678',
    //         'test@gmail.com',
    //         'Single',
    //         '',
    //         'Father Name',
    //         'Mother Name',
    //         'Spouse Name',
    //         'B Positive',
    //         'No',
    //         'ABCTY1234D',
    //         '0000 1111 2222',
    //         'Axis Bank',
    //         'AXIB0028901',
    //         '24898240942',
    //         'UAN0945049',
    //         'Yes',
    //         '942904',
    //         'Current Address',
    //         'Permanent Address',
    //         'CTC - Monthly',
    //         '18000',
    //         '=(AG2*50)/100',
    //         '=(AH2*50)/100',
    //         '',
    //         '',
    //         '',
    //         '',
    //         '=AH2-AI2',

    //     ],
    //         ['','=AG2*10']
    //     ];
    // }


    // public function map($row): array
    // {
    //     return [
    //         [
    //         'ABS0001',
    //         'Name',
    //         'abs@gmail.com',
    //         '0912345678',
    //         'Male',
    //         '28-06-2000',
    //         '14-11-2022',
    //         '',
    //         'It',
    //         '',
    //         'Chennai',
    //         'ABSM001',
    //         '0912345678',
    //         'test@gmail.com',
    //         'Single',
    //         '',
    //         'Father Name',
    //         'Mother Name',
    //         'Spouse Name',
    //         'B Positive',
    //         'No',
    //         'ABCTY1234D',
    //         '0000 1111 2222',
    //         'Axis Bank',
    //         'AXIB0028901',
    //         '24898240942',
    //         'UAN0945049',
    //         'Yes',
    //         '942904',
    //         'Current Address',
    //         'Permanent Address',
    //         'CTC - Monthly',
    //         '18000',
    //         '=(AG2*50)/100',
    //         '=(AH2*50)/100',
    //         '',
    //         '',
    //         '',
    //         '',
    //         '=AH2-AI2',

    //     ],
    //         ['','=AG2*10']
    //     ];
    // }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'P' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }


    public function registerEvents(): array
    {
        return [

            //  handle by a closure.
            AfterSheet::class => function (AfterSheet $event) {

                $row_count = 10;
                $column_count = 0;


             // set dropdown options
                $gender_options = [
                    'Male',
                    'Female',
                ];
                $legal_entity_option =   $this->client_list;
                $departments_option = $this->departments;
                $marital_option = $this->marital_status;
                $manager_code_option = $this->manager_code;
                $compansation_column = 'AF';

            // set dropdown list for Gender
                $validation_gender = $event->sheet->getCell("E3")->getDataValidation();
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

                $validation_bank_data = $event->sheet->getDataValidation('Y2');
                $validation_bank_data->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $validation_bank_data->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation_bank_data->setAllowBlank(false);
                $validation_bank_data->setShowInputMessage(true);
                $validation_bank_data->setShowErrorMessage(true);
                $validation_bank_data->setShowDropDown(true);
                $validation_bank_data->setErrorTitle('Input error');
                $validation_bank_data->setError('Value is not in list.');
                $validation_bank_data->setPromptTitle('Pick from list');
                $validation_bank_data->setPrompt('Please pick a value from the drop-down list.');
                $validation_bank_data->setFormula1('DropdownList!$Y$2:$Y$1000');

            // set dropdown list for Legal Entity
                $validation_entity = $event->sheet->getCell("H3")->getDataValidation();
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

                // // // set dropdown list for Legal Entity
                // $validation_dep = $event->sheet->getCell("I3")->getDataValidation();
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

                // //set dropdown list for marital status
                $validation_mar_sts = $event->sheet->getCell("O2")->getDataValidation();
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

                // //set dropdown list for managercode
                // $validation_mangr_code = $event->sheet->getCell("L3")->getDataValidation();
                // $validation_mangr_code->setType(DataValidation::TYPE_LIST);
                // $validation_mangr_code->setErrorStyle(DataValidation::STYLE_INFORMATION);
                // $validation_mangr_code->setAllowBlank(false);
                // $validation_mangr_code->setShowInputMessage(true);
                // $validation_mangr_code->setShowErrorMessage(true);
                // $validation_mangr_code->setShowDropDown(true);
                // $validation_mangr_code->setErrorTitle('Input error');
                // $validation_mangr_code->setError('Selected Option is not in list.');
                // $validation_mangr_code->setPromptTitle('Select Manager Code from list');
                // $validation_mangr_code->setPrompt('Please pick a  Manager Code from the drop-down list.');
                // $validation_mangr_code->setFormula1($manager_code_option);

                //set dropdown list for handicapped column
                $validation_Q = $event->sheet->getCell("U2")->getDataValidation();
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


                //set dropdown list for blood group column
                $validation_bld_grp = $event->sheet->getCell("T2")->getDataValidation();
                $validation_bld_grp->setType(DataValidation::TYPE_LIST);
                $validation_bld_grp->setErrorStyle(DataValidation::STYLE_WARNING);
                $validation_bld_grp->setAllowBlank(false);
                $validation_bld_grp->setShowInputMessage(true);
                $validation_bld_grp->setShowErrorMessage(true);
                $validation_bld_grp->setShowDropDown(true);
                $validation_bld_grp->setErrorTitle('Input error');
                $validation_bld_grp->setFormula1($this->blood_grp);



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


                //clone validation to remaining rows
                for ($i = 2; $i <= $row_count; $i++) {
                    $event->sheet->getCell("E{$i}")->setDataValidation(clone  $validation_gender);
                    $event->sheet->getCell("{$compansation_column}{$i}")->setDataValidation(clone    $validation_compansation);
                    $event->sheet->getCell("Y{$i}")->setDataValidation(clone    $validation_bank_data);
                    $event->sheet->getCell("H{$i}")->setDataValidation(clone  $validation_entity);
                    // $event->sheet->getCell("I{$i}")->setDataValidation(clone  $validation_dep);
                    $event->sheet->getCell("O{$i}")->setDataValidation(clone  $validation_mar_sts);
                    // $event->sheet->getCell("L{$i}")->setDataValidation(clone  $validation_mangr_code);
                    //$event->sheet->getCell("{$mobile_num_column}{$i}")->setDataValidation(clone    $validation_mobile);
                    $event->sheet->getCell("U{$i}")->setDataValidation(clone    $validation_Q);
                    $event->sheet->getCell("T{$i}")->setDataValidation(clone      $validation_bld_grp);
                }

                // set columns to autosize
                for ($i = 1; $i <= $column_count; $i++) {
                    $column = Coordinate::stringFromColumnIndex($i);
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // $event->sheet->getDelegate()->getColumnDimension('AG')->setVisible(false);
            },

        ];
    }
}
