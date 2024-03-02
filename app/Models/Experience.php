<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $table = 'vmt_employee_experiences';

    protected $fillable = [
        'user_id',
        'company_name',
        'location',
        'job_position',
        'period_from',
        'period_to',
    ];
}
