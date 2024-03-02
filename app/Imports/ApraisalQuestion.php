<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

use App\Models\VmtAppraisalQuestion;

use Illuminate\Support\Facades\Auth;

class ApraisalQuestion implements ToModel,  WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return $row;
    }

    public function startRow(): int
    {
        return 3;
    }
}
