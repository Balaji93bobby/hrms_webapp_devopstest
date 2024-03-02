<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmtPermissionModule extends Model
{
    use HasFactory;

    protected $table = 'vmt_perm_module';

    protected $fillable = ['module_name'];
}
