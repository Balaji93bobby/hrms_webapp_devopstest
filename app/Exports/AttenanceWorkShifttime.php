<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AttenanceWorkShifttime implements FromArray,WithCustomStartCell,WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $users;

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    public function array(): array
    {
        return $this->users;
    }

    public function startCell(): string
    {
        return 'C5';
    }

    public function headings(): array
    {
        return [
            'name',
            'email',
        ];
    }

}
