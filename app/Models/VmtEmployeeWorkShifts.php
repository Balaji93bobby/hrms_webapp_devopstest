<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmtEmployeeWorkShifts extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'vmt_employee_workshifts';
}
