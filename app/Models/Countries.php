<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;

    protected $table = 'vmt_country';

    protected $fillable = [
        'country_name',
        'country_code',
        'dialing_code',
        'currency_name',
        'currency_code',
        'timezone',
        'status',
    ];
}
