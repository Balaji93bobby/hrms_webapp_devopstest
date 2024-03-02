<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmtInvSection extends Model
{
    use HasFactory;
    protected $table = "vmt_inv_section";

    protected $fillable = ['section','particular','reference','max_amount'];
}
