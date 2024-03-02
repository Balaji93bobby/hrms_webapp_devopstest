<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeMail;
use App\Models\VmtEmployee;
use App\Models\VmtEmployeeDetails;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtClientMaster;
use App\Models\Compensatory;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class VmtEmployeeImport extends DefaultValueBinder implements ToModel,  WithHeadingRow,WithCalculatedFormulas
{
    
    public function model(array $row)
    {
        return $row;
    }

}
