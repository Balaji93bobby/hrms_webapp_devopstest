<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Department;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtEmployee;
use App\Models\VmtEmployeePaySlip;
use App\Models\VmtMaritalStatus;
use App\Models\vmt_employee_details;
use App\Models\VmtBloodGroup;
use App\Models\VmtClientMaster;
use App\Models\VmtEmployeeFamilyDetails;
use App\Models\VmtOrgTimePeriod;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class VmtReportsService
{
    public function fetchAnnualEarnedDetails($start_date, $end_date)
    {
        $response = array();
        $employees = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
            ->where('is_ssa', 0)->whereDate('doj', '<=', $end_date)->get(['users.id', 'user_code', 'name', 'doj', 'dob']);
        foreach ($employees as $singleEmployee) {
            $payslip_for_single_employee = VmtEmployeePaySlip::where('user_id', $singleEmployee->id)
                ->whereBetween('PAYROLL_MONTH', [$start_date, $end_date])->get([
                    'Earned_BASIC', 'BASIC_ARREAR', 'Earned_HRA', 'HRA_ARREAR', 'Earned_CHILD_EDU_ALLOWANCE',
                    'CHILD_EDU_ALLOWANCE_ARREAR', 'Earned_SPL_ALW', 'SPL_ALW_ARREAR', 'Overtime', 'TOTAL_EARNED_GROSS', 'PF_WAGES', 'PF_WAGES_ARREAR_EPFR', 'EPFR', 'EPFR_ARREAR',
                    'EDLI_CHARGES', 'EDLI_CHARGES_ARREARS', 'PF_ADMIN_CHARGES', 'PF_ADMIN_CHARGES_ARREARS', 'EMPLOYER_ESI', 'Employer_LWF', 'CTC', 'EPF_EE', 'EPF_EE_ARREAR', 'EMPLOYEE_ESIC',
                    'PROF_TAX', 'income_tax', 'SAL_ADV', 'CANTEEN_DEDN', 'OTHER_DEDUC', 'LWF', 'TOTAL_DEDUCTIONS', 'NET_TAKE_HOME', 'earned_stats_bonus', 'earned_stats_arrear', 'travel_conveyance', 'other_earnings'
                ]);
            foreach ($payslip_for_single_employee as $single_payslip) {
                $single_payslip = $single_payslip->toArray();
                foreach ($single_payslip as $key => $value) {
                    $singleEmployee[$key] = $singleEmployee[$key] + (int)$value;
                    //$singleEmployee->$key=$value;
                }
            }
            array_push($response, $singleEmployee->toArray());
        }
        return $response;
    }
    public function getEmployeesCTCDetails($type, $client_id, $active_status, $department_id,  $date_req)
    {
        $validator = Validator::make(
            $data = [
                'client_id' => $client_id,
                'type' => $type,
                'active_status' => $active_status,
                'department_id' => $department_id,
                'date' => $date_req,
            ],
            $rules = [
                'client_id' => 'nullable|exists:vmt_client_master,id',
                'type' => 'nullable',
                'active_status' => 'nullable',
                'department_id' => 'nullable|exists:vmt_department,id',
                'date' => 'nullable'
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        try {

            if (empty($client_id)) {
                $client_id = VmtClientMaster::pluck('id')->toArray();
            } else {
                $client_id =  $client_id;
            }
            // dd($client_id);

            // if (empty($active_status)) {
            //     $active_status = ['1', '0', '-1'];
            // } else {
            //     $active_status = $active_status;
            // }
            if (empty($date_req)) {
                $date_req = Carbon::now()->format('Y-m-d');
            }
            // if (empty($department_id)) {
            //     $get_department = Department::pluck('id');
            // } else {
            //     $get_department = $department_id;
            // }
            $dates = Carbon::now()->format('Y-m-d');
            $processed_array = array();
            $response = array();
            $headings = array();
            $temp_ar = array();
            $headers = array();

            $emp_ctc_detail = user::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                ->leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->leftJoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'users.id')
                ->leftJoin('vmt_employee_statutory_details', 'vmt_employee_statutory_details.user_id', '=', 'users.id')
                ->leftJoin('vmt_banks', 'vmt_banks.id', '=', 'vmt_employee_details.bank_id')
                ->where('users.is_ssa','=','0')
                ->where('vmt_employee_details.doj', '<', $date_req);

                if (!empty($active_status)) {
                    $emp_ctc_detail =  $emp_ctc_detail->whereIn('active', $active_status);
                }
                if (!empty($department_id)) {
                    $emp_ctc_detail = $emp_ctc_detail->whereIn('vmt_employee_office_details.department_id', $department_id);
                }
               $emp_ctc_detail = $emp_ctc_detail->get();


            foreach ($emp_ctc_detail as $singleemployeedata) {
                $temp_ar['Employee Code'] = $singleemployeedata->user_code;
                $temp_ar['Employee Name'] = $singleemployeedata->name;
                $temp_ar['Gender'] = strtoupper($singleemployeedata->gender);
                $temp_ar['Designation'] = $singleemployeedata->designation;
                $temp_ar['Department'] = Department::where('id', $singleemployeedata->department_id)->first()->name ?? '';
                if ($singleemployeedata->active == 1) {
                    $temp_ar['Employee Status'] = "Active";
                } else if ($singleemployeedata->active == -1) {
                    $temp_ar['Employee Status'] = "Exit";
                } else if ($singleemployeedata->active == 0) {
                    $temp_ar['Employee Status'] = 'Not Yet Active';
                }

                $temp_ar['DOJ'] = carbon::parse($singleemployeedata->doj)->format('d-M-Y');

                if ($type == 'detailed') {
                    $temp_ar['DOB'] = carbon::parse($singleemployeedata->dob)->format('d-M-Y');
                    $temp_ar['PAN Number'] =  $singleemployeedata->pan_number;
                    $temp_ar['Aadhar Number'] =  $singleemployeedata->aadhar_number;
                    $temp_ar['Mobile Number'] =  $singleemployeedata->mobile_number;
                    $temp_ar['Email ID'] =  $singleemployeedata->email;
                    $temp_ar['UAN NO'] =  $singleemployeedata->uan_number;
                    $temp_ar['EPF Number'] =  $singleemployeedata->epf_number;
                    $temp_ar['ESIC Number'] =  $singleemployeedata->esic_number;
                    $temp_ar['Bank Name'] =  $singleemployeedata->bank_name;
                    $temp_ar['Bank Account No'] =  $singleemployeedata->bank_account_number;
                    $temp_ar['IFSC Code'] =  $singleemployeedata->bank_ifsc_code;
                }

                $temp_ar['Basic'] = round((int) $singleemployeedata->basic);
                $temp_ar['House Rent Allowance'] = round((int) $singleemployeedata->hra);
                $temp_ar['Special Allowance'] = round((int) $singleemployeedata->special_allowance) == 0 ? "0" : round((int) $singleemployeedata->special_allowance);
                $temp_ar['Fixed Gross'] = round((int) $singleemployeedata->gross) == 0 ? "0" : round((int) $singleemployeedata->gross);
                $temp_ar['EPFER'] = round((int) $singleemployeedata->epf_employer_contribution) == 0 ? "0" : round((int) $singleemployeedata->epf_employer_contribution);
                $temp_ar['EDLI Charges'] = round((int) $singleemployeedata->edli_charges) == 0 ? "0" : round((int) $singleemployeedata->edli_charges);
                $temp_ar['PF ADMIN Charges'] = round((int) $singleemployeedata->pf_admin_charges) == 0 ? "0" : round((int) $singleemployeedata->pf_admin_charges);
                $temp_ar['ESICER'] = round((int) $singleemployeedata->esic_employer_contribution) == 0 ? "0" : round((int) $singleemployeedata->esic_employer_contribution);
                $temp_ar['Insurance'] =  round((int) $singleemployeedata->insurance) == 0 ? "0" : round((int) $singleemployeedata->insurance);
                $temp_ar['LWFER'] = round((int)$singleemployeedata->labour_welfare_fund) == 0 ? "0" : round((int) $singleemployeedata->labour_welfare_fund);
                $temp_ar['CTC'] = round((int) $singleemployeedata->cic) == 0 ? "0" : round((int) $singleemployeedata->cic);
                $temp_ar['EPFEE'] = round((int)  $singleemployeedata->epf_employee_contribution) == 0 ? "0" : round((int) $singleemployeedata->epf_employee_contribution);
                $temp_ar['ESICEE'] = round((int)$singleemployeedata->esic_employee) == 0 ? "0" : round((int) $singleemployeedata->esic_employee);
                $temp_ar['Income Tax'] = round((int)$singleemployeedata->Income_tax) == 0 ? "0" : round((int) $singleemployeedata->Income_tax);
                $temp_ar['Professional Tax'] = round((int) $singleemployeedata->professional_tax) == 0 ? "0" : round((int) $singleemployeedata->professional_tax);
                $temp_ar['LWFEE '] = round((int)$singleemployeedata->lwfee) == 0 ? "0" : round((int) $singleemployeedata->lwfee);
                $temp_ar['Total Deduction'] = round((int)$temp_ar['EPFEE'] + (int)$temp_ar['ESICEE'] +  (int)$temp_ar['Income Tax'] + (int)$temp_ar['Professional Tax'] + (int)$temp_ar['LWFEE ']);
                $temp_ar['NET Pay '] = round((int)$singleemployeedata->net_income) == 0 ? "0" : round((int) $singleemployeedata->net_income);
                array_push($processed_array, $temp_ar);
            }


            if ($processed_array) {
                foreach ($processed_array[0] as $key => $value) {
                    $headings = $key;
                    array_push($headers, $headings);
                }
                $response['headers'] =   $headers;
                $response['rows'] = $processed_array;
            } else {
                $response['headers'] = [];
                $response['rows'] = [];
            }
        } catch (\Exception $e) {
            $response = ([
                'status' => 'failure',
                'message' => 'Error while fetching data',
                'error' =>  $e->getMessage(),
                'error_verbose' => $e->getLine() . "  " . $e->getfile(),
            ]);
        }
        return $response;
    }

    public function getEmployeesMasterDetails($type, $client_id, $active_status, $department_id, $date_req)

    {

        $validator = Validator::make(
            $data = [
                'client_id' => $client_id,
                'type' => $type,
                'active_status' => $active_status,
                'department_id' => $department_id,
            ],
            $rules = [
                'client_id' => 'nullable|exists:vmt_client_master,id',
                'type' => 'nullable',
                'active_status' => 'nullable',
                'department_id' => 'nullable|exists:vmt_department,id',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try {

            if (empty($client_id)) {
                $client_id = VmtClientMaster::pluck('id');
            } else {
                $client_id =  $client_id;
            }

            if (empty($date_req)) {
                $date_req = Carbon::now()->format('Y-m-d');
            }

            $date = Carbon::now()->format('M-Y');
            $Category = 'All';
            $processed_array = array();
            $response = array();
            $headings = array();
            $type = '';

            $temp_ar = array();
            $emp_master_detail = User::leftjoin('vmt_employee_details as employee', 'employee.userid', '=', 'users.id')
                ->leftJoin('vmt_employee_office_details as office', 'office.user_id', '=', 'users.id')
                ->leftJoin('vmt_employee_compensatory_details as compensatory', 'compensatory.user_id', '=', 'users.id')
                ->leftJoin('vmt_employee_statutory_details as statutory', 'statutory.user_id', '=', 'users.id')
                ->leftJoin('vmt_banks as banks', 'banks.id', '=', 'employee.bank_id')
                ->leftJoin('vmt_department as department', 'department.id', '=', 'office.department_id')
                ->where('users.is_ssa','=','0')
                ->whereDate('employee.doj', '<', $date_req);
                // ->whereIn('users.client_id', $client_id)

                if (!empty($active_status)) {
                    $emp_master_detail =  $emp_master_detail->whereIn('active', $active_status);
                }
                if (!empty($department_id)) {
                    $emp_master_detail = $emp_master_detail->whereIn('office.department_id', $department_id);
                }
                $emp_master_detail = $emp_master_detail ->get([
                    'users.user_code as user_code', 'users.name as name', 'employee.gender as gender', 'employee.dob as dob', 'employee.doj as doj', 'users.active', 'employee.dol', 'employee.nationality', 'office.designation', 'office.department_id', 'office.officical_mail',
                    'office.official_mobile', 'office.l1_manager_code', 'office.work_location', 'employee.aadhar_number', 'employee.pan_number', 'statutory.uan_number', 'statutory.epf_number', 'statutory.esic_number',
                    'employee.mobile_number', 'users.email', 'employee.physically_challenged', 'employee.blood_group_id', 'banks.bank_name', 'employee.bank_account_number', 'employee.bank_ifsc_code', 'employee.no_of_children',
                    'employee.marital_status_id', 'employee.present_address', 'employee.permanent_address', 'compensatory.basic', 'compensatory.dearness_allowance', 'compensatory.hra', 'compensatory.child_education_allowance',
                    'compensatory.food_coupon', 'compensatory.washing_allowance', 'compensatory.special_allowance', 'compensatory.Statutory_bonus', 'compensatory.other_allowance', 'compensatory.lta', 'compensatory.driver_salary',
                    'compensatory.gross', 'compensatory.epf_employer_contribution', 'compensatory.esic_employer_contribution', 'compensatory.labour_welfare_fund', 'compensatory.cic', 'compensatory.epf_employee_contribution', 'compensatory.esic_employee', 'compensatory.professional_tax', 'compensatory.Income_tax', 'compensatory.lwfee', 'compensatory.net_income'
                ]);

            foreach ($emp_master_detail as $single_details) {
                // dd($single_details);
                $temp_ar['Employee Code'] = $single_details->user_code;
                $temp_ar['Employee Name'] = $single_details->name;
                $temp_ar['Gender'] = strtoupper($single_details->gender);
                $temp_ar['DOB'] = Carbon::parse($single_details->dob)->format('d-M-Y');
                $temp_ar['DOJ'] = carbon::parse($single_details->doj)->format('d-M-Y');
                if ($single_details->active == 1) {
                    $temp_ar['Employee Status'] = "Active";
                } else if ($single_details->active == -1) {
                    $temp_ar['Employee Status'] = "Exit";
                } else if ($single_details->active == 0) {
                    $temp_ar['Employee Status'] = 'Not Yet Active';

                }
                if(!empty($single_details->dol)){
                $temp_ar['Last Working Day'] = carbon::parse($single_details->dol)->format('d-M-Y');
                }else
                {
                    $temp_ar['Last Working Day']  = "-";

                }
                $temp_ar['Nationality'] = $single_details->nationality;
                // $temp_ar['legal entity'] = $single_details->;
                $temp_ar['Designation'] = $single_details->designation;
                $temp_ar['Department'] = Department::where('id', $single_details->department_id)->first()->name ?? '';
                $temp_ar['Process'] = $single_details->process;
                // $temp_ar['Business Unit'] = $single_details->;
                // $temp_ar['Employee Type'] = $single_details->;
                $temp_ar['Official Email'] = $single_details->officical_mail;
                $temp_ar['Office Mobile Number'] = $single_details->official_mobile;
                $temp_ar['Reporting Managers Employee Code'] = $single_details->l1_manager_code;
                //for   Reporting Manager Name

                if ($single_details->l1_manager_code != null || $single_details->l1_manager_code != 'undefined' || !empty($single_details->l1_manager_code)) {
                    if (empty(user::where('user_code', $single_details->l1_manager_code)->first()->name)) {
                        $temp_ar['Reporting Managers Name'] = null;
                    } else {
                        $temp_ar['Reporting Managers Name'] = user::where('user_code', $single_details->l1_manager_code)->first()->name;
                    }
                } else {
                    $temp_ar['Reporting Managers Name'] = null;
                }
                $temp_ar['Location'] = $single_details->work_location;
                $temp_ar['Aadhar Number'] = $single_details->aadhar_number;
                $temp_ar['PAN Number'] = $single_details->pan_number;
                $temp_ar['UAN Number'] = $single_details->uan_number;
                $temp_ar['EPF Number'] = $single_details->epf_number;
                $temp_ar['ESIC Number'] = $single_details->esic_number;
                // $temp_ar['PT location'] = $single_details->;
                $temp_ar['Mobile Number'] = $single_details->mobile_number;
                $temp_ar['Email id'] = $single_details->email;
                $temp_ar['Physically Handicapped'] = strtoupper($single_details->physically_challenged);
                $temp_ar['Blood Group'] = VmtBloodGroup::where('id', strtoupper($single_details->blood_group_id))->first()->name ?? '';
                $temp_ar['Bank Name'] = $single_details->bank_name;
                $temp_ar['Bank Account No'] = $single_details->bank_account_number;
                $temp_ar['IFSC Code'] = $single_details->bank_ifsc_code;
                // $temp_ar['Nominee Name'] = $single_details->;

                //for father mother detail need dob also
                $user_id = User::where('user_code', $single_details->user_code)->first()->id;
                $family_details =  VmtEmployeeFamilyDetails::where('user_id', $user_id)->get(['name', 'relationship']);
                $temp_ar['Father Name']='';
                $temp_ar['Mother Name']='';
                $temp_ar['Spouse Name']='';
                $temp_ar['Children Name'] ='';
                foreach ($family_details as $singleFamilyDetails) {
                    if (strtolower($singleFamilyDetails->relationship) == 'father') {
                        $temp_ar['Father Name'] = $singleFamilyDetails->name;
                    } else if (strtolower($singleFamilyDetails->relationship) == 'mother') {
                        $temp_ar['Mother Name'] = $singleFamilyDetails->name;
                    } else if (strtolower($singleFamilyDetails->relationship) == 'spouse') {
                        $temp_ar['Spouse Name'] = $singleFamilyDetails->name;
                    } else if (strtolower($singleFamilyDetails->relationship) == 'children') {
                        $temp_ar['Children Name'] = $singleFamilyDetails->name;
                    }
                }
                $temp_ar['No of Children'] = $single_details->no_of_children;
                $temp_ar['Marital Status'] = VmtMaritalStatus::where('id', $single_details->marital_status_id)->first()->name ?? '';
                // if ($temp_ar['Employee Code'] == 'DM034')
                //     dd($temp_ar);
                $temp_ar['Marriage Date'] = $single_details->wedding_date;
                $temp_ar['Present Address'] = $single_details->present_address;
                $temp_ar['Permanent Address'] = $single_details->permanent_address;
                $temp_ar['Basic'] = $single_details->basic;
                $temp_ar['Dearness Allowance'] = $single_details->dearness_allowance;
                // $temp_ar[' variable Dearness Allowance'] = $single_details->;
                $temp_ar['House Rent Allowance'] = $single_details->hra;
                $temp_ar['Child Education Allowance'] = $single_details->child_education_allowance;
                $temp_ar['Food Allowance'] = $single_details->food_allowance;
                $temp_ar['Washing Allowance'] = $single_details->washing_allowance;
                // $temp_ar['Uniform Allowance'] = $single_details->;
                $temp_ar['Special Allowance'] = round((int) $single_details->special_allowance) == 0 ? "0" : round((int) $single_details->special_allowance);
                $temp_ar['Statutory Bonus'] = round((int) $single_details->Statutory_bonus) == 0 ? "0" : round((int) $single_details->Statutory_bonus);
                $temp_ar['Other Allowance'] = round((int) $single_details->other_allowance) == 0 ? "0" : round((int) $single_details->other_allowance);
                $temp_ar['Leave Travel Allowance (LTA)'] = round((int) $single_details->lta) == 0 ? "0" : round((int) $single_details->lta);
                // $temp_ar['Telephone Reimbursement'] = $single_details->;
                // $temp_ar['vehicle Reimbursement'] = $single_details->;
                $temp_ar['Driver Salary'] = $single_details->driver_salary;
                $temp_ar['Fixed Gross'] = round((int) $single_details->gross) == 0 ? "0" : round((int) $single_details->gross);
                // $temp_ar['Pf Wages'] = $single_details->;
                $temp_ar['EPFER'] = round((int) $single_details->epf_employer_contribution) == 0 ? "0" : round((int) $single_details->epf_employer_contribution);
                $temp_ar['EDLI Charges'] = round((int) $single_details->edli_charges) == 0 ? "0" : round((int) $single_details->edli_charges);
                $temp_ar['PF ADMIN Charges'] = round((int) $single_details->pf_admin_charges) == 0 ? "0" : round((int) $single_details->pf_admin_charges);
                $temp_ar['ESICER'] = round((int) $single_details->esic_employer_contribution) == 0 ? "0" : round((int) $single_details->esic_employer_contribution);
                // $temp_ar[' employer Insurance'] = $single_details->;
                $temp_ar['LWFER'] = round((int)$single_details->labour_welfare_fund) == 0 ? "0" : round((int) $single_details->labour_welfare_fund);
                $temp_ar['CTC'] = round((int) $single_details->cic) == 0 ? "0" : round((int) $single_details->cic);
                $temp_ar['EPFEE'] = round((int)  $single_details->epf_employee_contribution) == 0 ? "0" : round((int) $single_details->epf_employee_contribution);
                $temp_ar['ESICEE'] = round((int)$single_details->esic_employee) == 0 ? "0" : round((int) $single_details->esic_employee);
                $temp_ar['Professional Tax'] = round((int) $single_details->professional_tax) == 0 ? "0" : round((int) $single_details->professional_tax);
                $temp_ar['Income Tax'] = round((int)$single_details->Income_tax) == 0 ? "0" : round((int) $single_details->Income_tax);
                $temp_ar['LWFEE'] = round((int)$single_details->lwfee) == 0 ? "0" : round((int) $single_details->lwfee);
                // $temp_ar[' employee Insurance'] = $single_details->;
                $temp_ar['Total Deduction'] = round((int)$temp_ar['EPFEE'] + (int)$temp_ar['ESICEE'] +  (int)$temp_ar['Income Tax'] + (int)$temp_ar['Professional Tax'] + (int)$temp_ar['LWFEE']);
                $temp_ar['NET Pay '] = round((int)$single_details->net_income) == 0 ? "0" : round((int) $single_details->net_income);





                // $temp_ar['Business Unit'] = $single_details->process;
                // $temp_ar['Worker Type'] = $single_details->work_location;
                // $temp_ar['Salary Payment Mode'] = $single_details->;
                // $temp_ar['IFSC Code'] = $single_details->bank_ifsc_code;
                // $temp_ar['NATIONALITY'] = $single_details->nationality;
                // $temp_ar['Communication Allowance'] = $single_details->communication_allowance;
                // $temp_ar['Employer EPF'] = $single_details->washing_allowance;
                // if ($single_details->esic_number =='NOT APPLICABLE' ) {
                //     $temp_ar['ESI Eligible'] = "Yes";
                // } else if ($single_details->esic_number != 'NOT APPLICABLE') {
                //     $temp_ar['ESI Eligible'] = "No";


                // $temp_ar['Employer EPF'] = $single_details->epf_employer_contribution;
                // $temp_ar['Employer ESIC	'] = $single_details->esic_employer_contribution;

                //Get family details
                array_push($processed_array, $temp_ar);
                unset($temp_ar);
            }

            if ($processed_array) {
                foreach ($processed_array[0] as $key => $value) {
                    array_push($headings, $key);
                }
                $response['headers'] = $headings;
                $response['rows'] = $processed_array;
            } else {
                $response['headers'] = [];
                $response['rows'] = [];
            }
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while fetching data',
                'error' =>  $e->getMessage(),
                'line' => $e->getTraceAsString(),
                'error_verbose' => $e->getLine()
            ];
        }
        // dd($response);
        return $response;
    }
}
