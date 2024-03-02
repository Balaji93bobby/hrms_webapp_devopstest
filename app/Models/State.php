<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $table = 'vmt_states';

    protected $fillable = [
        'country_id',
        'country_code',
        'state_name',
        'status',
    ];
}
