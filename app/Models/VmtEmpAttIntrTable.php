<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*
    A - Absent
    P - present
    WO - Weekoff
    P/EG - present and early going
    P/LC - present and latcoming
    P/EG/LC - present &earlygoing and late coming
    H - holiday

*/
class VmtEmpAttIntrTable extends Model
{
    use HasFactory;
    protected $table = 'vmt_emp_att_intrtable';
}
