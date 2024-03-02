<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmtRolesDescription extends Model
{
    use HasFactory;
    protected $table = 'vmt_roles_description';

    protected $fillable = ['roles_id',
                            'description'];
}
