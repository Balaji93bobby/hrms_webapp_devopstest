<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vmtHolidays extends Model
{
    use HasFactory;



    protected $table = 'vmt_holidays';

    protected $fillable = [
        'holiday_name',
        'holiday_date',
        'holiday_description',
        'image',
    ];
    
}
