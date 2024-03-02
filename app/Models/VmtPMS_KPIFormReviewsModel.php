<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VmtPMS_KPIFormReviewsModel extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'vmt_pms_kpiform_reviews';

    function getPmsKpiFormAssigned(){
        return $this->belongsTo(VmtPMS_KPIFormAssignedModel::class,'vmt_pms_kpiform_assigned_id');
    }

    function getUserAssigneeDetails(){
        return $this->belongsTo(User::class,'assignee_id');
    }
}
