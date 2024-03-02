<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class VmtInvEmpFormdata extends Model
{
    use HasFactory;

    protected $table = "vmt_inv_emp_formdata";

    protected $fillable = [ 'f_emp_id ','fs_id','dec_amount','json_popups_value'];




    }

