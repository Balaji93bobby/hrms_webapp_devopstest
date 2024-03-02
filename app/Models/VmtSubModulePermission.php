<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmtSubModulePermission extends Model
{
    use HasFactory;

    protected $table = 'vmt_perm_sub_module';

    // protected $fillable = ['per_module_id','permission_id'];
}
