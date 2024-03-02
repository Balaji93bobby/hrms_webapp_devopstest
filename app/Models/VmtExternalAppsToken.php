<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmtExternalAppsToken extends Model
{
    use HasFactory;

    protected $table="vmt_externalapps_tokens";

    protected $fillable = [
        'client_id',
        'extapp_type_id',
        'access_token',
        'token_validity',
        'additional_data',
        'token_generated_time',
        'recent_token_accessed_time',
    ];
}
