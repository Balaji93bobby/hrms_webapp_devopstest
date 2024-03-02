<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VmtPMS_KPIFormAssignedModel extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'vmt_pms_kpiform_assigned';

    //protected $appends = ['attr_reviewer_accepted_status'];

    // function getAttrReviewerAcceptedStatusAttribute(){
    //     // dd($this->is_reviewer_accepted);
    //     // if($this->is_reviewer_accepted == null)
    //     //     dd("NULL at ");

    //     //dd($this);
    //     $json_is_reviewer_accepted = $this->is_reviewer_accepted;

    //     $array = json_decode($json_is_reviewer_accepted, true);
    //     $array_values = array_values($array);

    //     //Check for null
    //     if(in_array(null, $array_values)){
    //         return -1;
    //     }
    //     else         //Check for 0
    //     if(in_array(0, $array_values)){
    //         return 0;
    //     }
    //     else         //Check for 1
    //     if(in_array(1, $array_values)){
    //         return 1;
    //     }

    // }


    function getPmsKpiFormReviews(){
        return $this->hasMany(VmtPMS_KPIFormReviewsModel::class,'vmt_pms_kpiform_assigned_id');
    }

    function getPmsKpiFormColumnDetails(){
        return $this->belongsTo(VmtPMS_KPIFormModel::class,'vmt_pms_kpiform_id');
    }


    function getUserDetails($assignersId){
        $userEmpNames = [];
        $userEmpNos = [];

        $userDetails = User::find($assignersId);
        if(!empty($userDetails)){
            $userEmpNames[] = $userDetails->name;
            $empDetails = VmtEmployee::where('userid',$assignersId)->first();
            if(!empty($empDetails)){

                $userEmpNos[] = $userDetails->user_code;
            }
        }
        $userEmpNames = implode(',',$userEmpNames);
        $userEmpNos = implode(',',$userEmpNos);
        $result = [
            'userNames' =>$userEmpNames,
            'userEmpIds' =>$userEmpNos,
        ];
        return $result;

    }


    function getAsisgnedKpiFormReviewDetails($assigneeId, $kpiFormAssignedId){
        $reviewDetails = VmtPMS_KPIFormReviewsModel::where('vmt_pms_kpiform_assigned_id',$kpiFormAssignedId)->where('assignee_id',$assigneeId)->first();
        if(!empty($reviewDetails))
            return $reviewDetails;
    }
}
