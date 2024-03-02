<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmtLeavePolicyHolidays extends Model
{
   
    use HasFactory;
    protected $table = 'vmt_leavepolicy_holidays';
    protected $fillable = [
        'id',
        'leavepolicy_id',
        'holiday_id',
         
    ];
}
