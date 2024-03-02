<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmtPMS_KPIFormModel extends Model
{
    use HasFactory;

protected $table = 'vmt_pms_kpiform';

    function getPmsKpiFormAssignedDetails(){
        return $this->hasMany(VmtPMS_KPIFormAssignedModel::class);
    }

    function getPmsKpiFormDetails(){
        return $this->hasMany(VmtPMS_KPIFormDetailsModel::class,'vmt_pms_kpiform_id');
    }
}
