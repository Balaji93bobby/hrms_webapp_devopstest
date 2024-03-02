<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vmtLocationsHoliday extends Model
{
    use HasFactory;
    protected $table = 'vmt_locations_holiday';

    protected $fillable = [
        'vmt_locations_id',
        'vmt_holidays_list_id',
    ];
}
