<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportLeaveBalance implements ToModel,  WithHeadingRow, WithCalculatedFormulas
{

    public function model(array $row)
    {
        return $row;
    }
}
