<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigPms extends Model
{
    use HasFactory;

    protected $table = 'vmt_config_pms';

    protected $fillable = [
        'user_id',
        'selected_columns',
        'selected_head',
        'column_header',
    ];
}
