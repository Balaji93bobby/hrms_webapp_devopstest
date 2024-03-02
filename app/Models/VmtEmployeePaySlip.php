<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmtEmployeePaySlip extends Model
{
    use HasFactory;

    protected $table = 'vmt_employee_payslip';

        protected $fillable = [
            "EMP_NO",
            "EMP_NAME",
            "Gender",
            "DESIGNATION",
            "DEPARTMENT",
            "DOJ",
            "LOCATION",
            "DOB" ,
            "Father_Name",
            "PAN_Number",
            "Aadhar_Number",
            "UAN",
            "EPF_Number",
            "ESIC_Number" ,
            "Bank_Name" ,
            "Account_Number" ,
            "Bank_IFSC_Code",
            "PAYROLL_MONTH",
            "BASIC" ,
            "HRA",
            "CHILD_EDU_ALLOWANCE",
            "SPL_ALW",
            "TOTAL_FIXED_GROSS" ,
            "MONTH_DAYS",
            "Worked_Days",
            "Arrears_Days",
            "LOP",
            "Earned_BASIC",
            "BASIC_ARREAR",
            "Earned_HRA",
            "HRA_ARREAR" ,
            "Earned_CHILD_EDU_ALLOWANCE" ,
            "CHILD_EDU_ALLOWANCE_ARREAR" ,
            "Earned_SPL_ALW" ,
            "SPL_ALW_ARREAR",
            "Overtime",
            "TOTAL_EARNED_GROSS",
            "PF_WAGES",
            "PF_WAGES_ARREAR_EPFR" ,
            "EPFR",
            "EPFR_ARREAR" , "EDLI_CHARGES" , "EDLI_CHARGES_ARREARS" ,  "PF_ADMIN_CHARGES" ,"PF_ADMIN_CHARGES_ARREARS" ,
            "EMPLOYER_ESI" ,
            "Employer_LWF" ,
            "CTC" ,
            "EPF_EE" ,
            "EPF_EE_ARREAR" ,
            "EMPLOYEE_ESIC",
            "PROF_TAX",
            "TDS",
            "SAL_ADV",
            "CANTEEN_DEDN",
            "OTHER_DEDUC",
            "LWF",
            "TOTAL_DEDUCTIONS",
            "NET_TAKE_HOME",
            "Rupees",
            "EL_Opn_Bal",
            "Availed_EL" ,
            "Balance_EL",
            "Rename",
            "Email" ,
            "Greetings"];

        public function user() {
            return $this->belongsTo(User::class);
        }

}

