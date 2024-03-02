<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmtInvSectionGroup extends Model
{
    use HasFactory;

    protected $table = "vmt_inv_section_group";

    protected $fillable = ['section_group'];
}
