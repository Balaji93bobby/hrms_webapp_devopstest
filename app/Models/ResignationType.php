<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResignationType extends Model
{
    use HasFactory;
    protected $table = 'vmt_resignation_type';
    protected $fillable = [
       'reason_type'
    ];
}
