<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmtLeavePolicy extends Model
{ 
    use HasFactory;
    protected $table = 'vmt_leavepolicy';
    protected $fillable = [
        'leave_policy_name',
        'is_active',
         
    ];

}
