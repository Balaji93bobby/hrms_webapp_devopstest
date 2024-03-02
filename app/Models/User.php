<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\VmtEmployeeFamilyDetails;
use App\Models\VmtEmployeeEmergencyContactDetails;
use App\Models\Experience;
use App\Models\VmtEmployeeStatutoryDetails;
use App\Models\VmtEmployeePaySlip;
use App\Models\VmtEmployeePaySlipV2;


class User extends Authenticatable
{
    use HasRoles;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'client_code',
        'avatar',
        'user_code',
        'can_login',//user can login.
        'active',//user can access all app features
        'is_onboarded',//if false, user prompted to fill onboard form
        'onboard_type',
        'is_ssa',
        'is_default_password_updated',
        'org_role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // get employee details by userid
    public function getEmployeeDetails() {
        return $this->hasOne(VmtEmployee::class,'userid');
    }

    // get employee Office details by user_id
    public function getEmployeeOfficeDetails() {
        return $this->hasOne(VmtEmployeeOfficeDetails::class,'user_id');
    }

    function getKpiAssignedFormReview(){
        return $this->hasMany(VmtPMS_KPIFormReviewsModel::class,'assignee_id');
    }

    public function getFamilyDetails() {
        return $this->hasMany(VmtEmployeeFamilyDetails::class,'user_id');
    }

    function getEmergencyContactsDetails() {
        return $this->hasMany(VmtEmployeeEmergencyContactDetails::class,'user_id');
    }
    function getExperienceDetails() {
        return $this->hasMany(Experience::class,'user_id');
    }
    function getStatutoryDetails() {
        return $this->hasOne(VmtEmployeeStatutoryDetails::class,'user_id');
    }
    function getEmployeeDocuments() {
        return $this->hasMany(VmtEmployeeDocuments::class,'user_id');
    }

    function single_payslip_detail(){
        return $this->hasOne(VmtEmployeePaySlipV2::class,'emp_payroll_id');
    }
    function single_payslip_empid(){
        return $this->hasOne(VmtEmployeePayroll::class,'user_id');
    }
    function single_payslip_month(){
        return $this->hasOne(VmtEmployeePayroll::class,'client_id');
    }


    function array_notifications(){
        return $this->hasMany(VmtNotifications::class,'user_id');
    }
}
