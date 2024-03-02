<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmtLeaves extends Model
{
    use HasFactory;

    protected $fillable = [
        'leave_type',
        'leave_max_limit',
        'created_at',
        'updated_at',
    ];
}
