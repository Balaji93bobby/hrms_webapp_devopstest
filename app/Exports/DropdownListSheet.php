<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Bank;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Events\AfterSheet;


class DropdownListSheet implements  WithTitle ,FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */


    public function collection()
    {
        $bank_details[] = (sprintf('"%s"', implode(',', Bank::pluck('bank_name')->toArray())));
        
        // Fetch your long list of items here
        $items = [
            $bank_details,
        ];

        return new Collection($items);
    }



    public function title(): string
    {
        return 'DropdownList';
    }



}

