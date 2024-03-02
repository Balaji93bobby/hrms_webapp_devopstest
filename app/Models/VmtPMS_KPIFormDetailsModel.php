<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmtPMS_KPIFormDetailsModel extends Model
{
    use HasFactory;

    protected $table = 'vmt_pms_kpiform_details';

    function getPmsKpiFormColumnDetails(){
        return $this->belongsTo(VmtPMS_KPIFormModel::class);
    }
}
