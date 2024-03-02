<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vmtLocations extends Model
{
    use HasFactory;
    protected $table = 'vmt_locations';

    protected $fillable = [
        'name',
    ];

}
