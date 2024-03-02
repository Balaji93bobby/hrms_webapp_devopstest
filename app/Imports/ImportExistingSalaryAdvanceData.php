<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;


class ImportExistingSalaryAdvanceData implements ToModel,  WithHeadingRow, WithCalculatedFormulas
{

    public function model(array $row)
    {
        return $row;
    }
}
