<?php

namespace App\Services;

use App\Models\Countries;
use App\Models\State;
use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use \DateTime;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;
use \stdClass;
use App\Models\User;
use App\Models\VmtEmployee;
use App\Http\Controllers\VmtTestingController;
use App\Models\VmtBloodGroup;
use App\Models\Department;
use App\Models\VmtMaritalStatus;
use App\Models\Bank;
use App\Models\VmtClientMaster;
use App\Models\VmtEmployeeWorkShifts;
use App\Models\VmtWorkShifts;
use App\Models\VmtMasterConfig;


use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtEmployeeCompensatoryDetails;
use App\Models\Compensatory;
use App\Models\VmtEmployeeStatutoryDetails;
use App\Models\VmtEmployeeFamilyDetails;
use App\Models\VmtPayrollComponents;
use App\Models\VmtOrgRoles;
use App\Models\VmtDocuments;
use App\Models\VmtEmployeeDocuments;
use App\Notifications\ViewNotification;
use Illuminate\Support\Facades\Notification;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;


class VmtEmployeeService
{

    protected $org_roles;

    protected $session;
    protected $instance;

    /**
     * Constructs a new cart object.
     *
     * @param Illuminate\Session\SessionManager $session
     */
    public function __construct(SessionManager $session)
    {
        $this->session = $session;
        $this->org_roles = VmtOrgRoles::all(['id', 'name'])->keyBy('name');
    }

    public function testUser($user_data)
    {
        //dd($user_data);

        $newUser = User::where('user_code', $user_data['employee_code']);

        if ($newUser->exists()) {
            $newUser = $newUser->first();
        } else {
            $newUser = new User;
        }

        $newUser->email = "Fake@gmail.com";
        $newUser->save();

        //dd($newUser);
        dd($this->org_roles->toArray());
    }


    public function createOrUpdate_OnboardData($data, $can_onboard_employee, $existing_user_id = null, $onboard_type = null)
    {
        //dd("heeey");
        $response = $this->createOrUpdate_User(data: $data, can_onboard_employee: $can_onboard_employee, user_id: $existing_user_id, onboard_type: $onboard_type);

        if (!empty($response) && $response['status'] == 'success') {

            try {

                $user_data = $response['data'];

                $save_details = $this->Save_Employee_NormalQuick_OnboardData($data, $user_data, $onboard_type);

                $response = ([
                    'status' => $save_details['status'],
                    'message' => 'Employee details saved successfully',
                    'data' => $save_details
                ]);

                return $response;
            } catch (\Exception $e) {

                return $response = ([
                    'status' => 'failure',
                    'message' => 'Error while saving record ',
                    'data' => $e->getMessage() . " " . $e->getline()

                ]);
            }
        } else {

            return $response = ([
                'status' => $response['status'],
                'message' => 'Error while saving record ',
                'data' => $response['data']

            ]);
        }
    }

    public function createOrUpdate_BulkOnboardData($data, $can_onboard_employee, $existing_user_id = null, $onboard_type = null)
    {
        //dd("heeey");
        $response = $this->createOrUpdate_User(data: $data, can_onboard_employee: $can_onboard_employee, user_id: $existing_user_id, onboard_type: $onboard_type);

        if (!empty($response) && $response['status'] == 'success') {

            try {

                $user_data = $response['data'];

                $save_details = $this->Save_Employee_Bulk_OnboardData($data, $user_data, $onboard_type);

                $response = ([
                    'status' => $save_details['status'],
                    'message' => 'Employee details saved successfully',
                    'data' => $save_details
                ]);

                return $response;
            } catch (\Exception $e) {

                return $response = ([
                    'status' => 'failure',
                    'message' => 'Error while saving record ',
                    'data' => $e->getMessage() . " " . $e->getline()

                ]);
            }
        } else {

            return $response = ([
                'status' => $response['status'],
                'message' => 'Error while saving record ',
                'data' => $response['data']

            ]);
        }
    }
    public function createOrUpdate_QuickOnboardData($data, $can_onboard_employee, $existing_user_id = null, $onboard_type = null)
    {
        //dd("heeey");
        $response = $this->createOrUpdate_User(data: $data, can_onboard_employee: $can_onboard_employee, user_id: $existing_user_id, onboard_type: $onboard_type);

        if (!empty($response) && $response['status'] == 'success') {

            try {

                $user_data = $response['data'];

                $save_details = $this->Save_Employee_QuickOnboard_Data($data, $user_data, $onboard_type);

                $response = ([
                    'status' => $save_details['status'],
                    'message' => 'Employee details saved successfully',
                    'data' => $save_details
                ]);

                return $response;
            } catch (\Exception $e) {

                return $response = ([
                    'status' => 'failure',
                    'message' => 'Error while saving record ',
                    'data' => $e->getMessage() . " " . $e->getline()

                ]);
            }
        } else {

            return $response = ([
                'status' => $response['status'],
                'message' => 'Error while saving record ',
                'data' => $response['data']

            ]);
        }
    }
    private function createOrUpdate_User($data, $can_onboard_employee, $onboard_type, $user_id = null)
    {
        $newUser = null;

        try {

            if (!empty($user_id)) {

                $newUser = User::where('id', $user_id)->first();

                //Update existing user
                $newUser->name = $data['employee_name'];
                $newUser->email = empty($data["email"]) ? '' : $data["email"];
                $newUser->is_onboarded = $can_onboard_employee;
                //$newUser->password = Hash::make('Abs@123123');
                //$newUser->avatar = $data['employee_code'] . '_avatar.jpg';
                //$newUser->active = '0';
                //$newUser->onboard_type = 'normal';
                //$newUser->org_role = '5';
                //$newUser->is_ssa = '0';
                $newUser->save();
            } else {
                $newUser = $this->CreateNewUser($data, $can_onboard_employee, $onboard_type);
            }

            $response = ([
                'status' => 'success',
                'message' => '',
                'data' => $newUser
            ]);

            return $response;
        } catch (\Exception $e) {

            return $response = ([
                'status' => 'failure',
                'message' => '',
                'data' => $e->getMessage()
            ]);
        }
    }

    private function CreateNewUser($data, $can_onboard_employee, $onboard_type)
    {
        try {

            $newUser = new User;
            $newUser->name = $data['employee_name'];
            $newUser->email = empty($data["email"]) ? '' : $data["email"];
            $newUser->password = Hash::make('Abs@123123');
            //$newUser->avatar = $data['employee_code'] . '_avatar.jpg';
            $newUser->user_code = strtoupper($data['employee_code']);
            if ($onboard_type == 'normal') {

                $newUser->client_id = sessionGetSelectedClientid();
            } else {
                $emp_client_code = trim($data['legal_entity']);

                $newUser->client_id = VmtClientMaster::where('client_fullname', $emp_client_code)->first()->id;

            }

            $newUser->active = '0';
            $newUser->is_default_password_updated = '0';
            $newUser->is_onboarded = $can_onboard_employee;
            $newUser->onboard_type = $onboard_type; //normal, quick, bulk
            $newUser->org_role = '5';
            $newUser->is_ssa = '0';
            $newUser->save();

            return $response = $newUser;
        } catch (\Exception $e) {


            return $response = ([
                'status' => 'failure',
                'message' => '',
                'data' => "Error in VmtEmployeeService::CreateNewUser() : " . $e->getMessage() . " " . $e->getFile()
            ]);
        }
    }
    public function Save_Employee_NormalQuick_OnboardData($data, $user_data, $onboard_type)
    {

        try {

            $user_id = $user_data->id;

            $newEmployee = VmtEmployee::where('userid', $user_id);

            if ($newEmployee->exists()) {
                $newEmployee = $newEmployee->first();
            } else {
                $newEmployee = new VmtEmployee;
            }

            $dob = $data["dob"] ?? '';
            $doj = $data["doj"] ?? '';
            $passport_date = $data["passport_date"] ?? '';

            $newEmployee->userid = $user_id;
            $newEmployee->marital_status_id = $data["marital_status"] ?? '';
            $newEmployee->dob = $dob ? $this->getdateFormatForDb($dob, $user_id) : '';
            $newEmployee->doj = $doj ? $this->getdateFormatForDb($doj, $user_id) : '';
            // $newEmployee->dol   =  $doj ? $this->getdateFormatForDb($doj, $user_id) : '';
            $newEmployee->gender = $data["gender"] ?? '';
            $data_mobile_number = empty($data["mobile_number"]) ? "" : strval($data["mobile_number"]);
            $newEmployee->mobile_number = $data_mobile_number;
            $newEmployee->aadhar_number = $data["aadhar_number"] ?? '';
            $newEmployee->pan_number = isset($data["pan_number"]) ? ($data["pan_number"]) : " ";
            $newEmployee->dl_no = $data["dl_no"] ?? '';
            $newEmployee->nationality = $data["nationality"] ?? '';
            $newEmployee->passport_number = $data["passport_no"] ?? '';
            $newEmployee->passport_date = $passport_date ? $this->getdateFormatForDb($passport_date, $user_id) : '';
            //$newEmployee->pan_ack   =    $data["pan_ack"];
            $newEmployee->location = $data["work_location"] ?? '';
            $newEmployee->blood_group_id = $data["blood_group_name"] ?? '';
            $newEmployee->physically_challenged = $data["physically_challenged"] ?? 'no';
            $newEmployee->bank_id = $data["bank_id"] ?? '';
            $newEmployee->bank_account_number = $data["AccountNumber"] ?? '';
            $newEmployee->bank_ifsc_code = $data["bank_ifsc"] ?? '';

            //employee address details
            $newEmployee->current_address_line_1 = $data["current_address_line_1"] ?? '';
            $newEmployee->current_address_line_2 = $data["current_address_line_2"] ?? '';
            $newEmployee->permanent_address_line_1 = $data["permanent_address_line_1"] ?? '';
            $newEmployee->permanent_address_line_2 = $data["permanent_address_line_2"] ?? '';
            $newEmployee->current_country_id = $data["current_country"] ?? '';
            $newEmployee->permanent_country_id = $data["permanent_country"] ?? '';
            $newEmployee->current_state_id = $data["current_state"] ?? '';
            $newEmployee->permanent_state_id = $data["permanent_state"] ?? '';
            $newEmployee->current_city = $data["current_city"] ?? '';
            $newEmployee->permanent_city = $data["permanent_city"] ?? '';
            $newEmployee->current_pincode = $data["current_pincode"] ?? '';
            $newEmployee->permanent_pincode = $data["permanent_pincode"] ?? '';
            $newEmployee->no_of_children = $data["no_of_children"] ?? 0;

            $newEmployee->save();
            //save employee office details

            $empOffice = VmtEmployeeOfficeDetails::where('user_id', $user_id);

            if ($empOffice->exists()) {
                $empOffice = $empOffice->first();
            } else {
                $empOffice = new VmtEmployeeOfficeDetails;
            }
            //dd($data);
            $confirmation_period = $data['confirmation_period'] ?? '';
            $empOffice->user_id = $user_id;
            $empOffice->department_id = $data["department"] ?? '';
            $empOffice->process = $data["process"] ?? '';
            $empOffice->designation = $data["designation"] ?? '';
            $empOffice->cost_center = $data["cost_center"] ?? '';
            $empOffice->probation_period = $data['probation_period'] ?? '';
            $empOffice->confirmation_period = $confirmation_period ? $this->getdateFormatForDb($confirmation_period, $user_id) : '';
            $empOffice->holiday_location = $data["holiday_location"] ?? '';
            $empOffice->l1_manager_code = $data["l1_manager_code"] ?? '';
            $empOffice->work_location = $data["work_location"] ?? '';
            $empOffice->officical_mail = $data["officical_mail"] ?? '';
            $empOffice->official_mobile = $data["official_mobile"] ?? '';
            $empOffice->emp_notice = $data["emp_notice"] ?? '';
            $empOffice->save();

            //assign default workshift to employee

            $emp_workshift = new VmtEmployeeWorkShifts;
            $emp_workshift->user_id = $user_id;
            $work_shift_id = VmtWorkShifts::where('is_default', '1')->first();
            $emp_shift_id = VmtEmployeeWorkShifts::where('user_id', '$user_id')->first();
            if (!empty($work_shift_id)) {
                $emp_workshift->work_shift_id = $work_shift_id->id;
            }
            if (empty($emp_shift_id)) {
                $emp_workshift->is_active = '1';
                $emp_workshift->save();
            }



            //save statutory data of employee
            $newEmployee_statutoryDetails = VmtEmployeeStatutoryDetails::where('user_id', $user_id);

            if ($newEmployee_statutoryDetails->exists()) {
                $newEmployee_statutoryDetails = $newEmployee_statutoryDetails->first();
            } else {
                $newEmployee_statutoryDetails = new VmtEmployeeStatutoryDetails;
            }

            //Statutory Details

            $newEmployee_statutoryDetails->user_id = $user_id;
            $newEmployee_statutoryDetails->uan_number = $data["uan_number"] ?? '';
            $newEmployee_statutoryDetails->epf_number = $data["epf_number"] ?? '';
            $newEmployee_statutoryDetails->esic_number = $data["esic_number"] ?? '';
            $newEmployee_statutoryDetails->pf_applicable = $data["pf_applicable"] ?? '';
            $newEmployee_statutoryDetails->esic_applicable = $data["esic_applicable"] ?? '';
            $newEmployee_statutoryDetails->ptax_location_state_id = $data["ptax_location"] ?? '';
            $newEmployee_statutoryDetails->tax_regime = $data["tax_regime "] ?? '';
            $newEmployee_statutoryDetails->lwf_location_state_id = $data["lwf_location"] ?? '';
            $newEmployee_statutoryDetails->save();

            //save family data of employees

            VmtEmployeeFamilyDetails::where('user_id', $user_id)->delete();
            //save father data
            if (!empty($data['father_name'])) {
                $familyMember = new VmtEmployeeFamilyDetails;
                $familyMember->user_id = $user_id;
                $familyMember->name = $data['father_name'];
                $familyMember->relationship = 'Father';
                $familyMember->gender = $data['father_gender'];

                if (!empty($data["dob_father"])) {
                    $dob_father = $data["dob_father"];
                    $familyMember->dob = $this->getdateFormatForDb($dob_father, $user_id);
                }
                $familyMember->save();
            }
            //save mother data
            if (!empty($data['mother_name'])) {
                $familyMember = new VmtEmployeeFamilyDetails;
                $familyMember->user_id = $user_id;
                $familyMember->name = $data['mother_name'];
                $familyMember->relationship = 'Mother';
                $familyMember->gender = $data['mother_gender'];

                if (!empty($data["dob_mother"])) {
                    $dob_mother = $data["dob_mother"];
                    $familyMember->dob = $this->getdateFormatForDb($dob_mother, $user_id);
                }
                $familyMember->save();
            }
            //save spouse data
            if (!empty($data['spouse_name'])) {
                $familyMember = new VmtEmployeeFamilyDetails;
                $familyMember->user_id = $user_id;
                $familyMember->name = $data['spouse_name'];
                $familyMember->relationship = 'Spouse';
                $familyMember->gender = $data['spouse_gender'] ?? '';

                if (!empty($data["dob_spouse"])) {
                    $dob_spouse = $data["dob_spouse"];
                    $familyMember->dob = $this->getdateFormatForDb($dob_spouse, $user_id);
                }

                if (!empty($data["wedding_date"])) {
                    $wedding_date = $data["wedding_date"];
                    $familyMember->wedding_date = $this->getdateFormatForDb($wedding_date, $user_id);
                }
                $familyMember->save();
            }
            //save child data
            if (!empty($data['child_name'])) {
                $familyMember = new VmtEmployeeFamilyDetails;
                $familyMember->user_id = $user_id;
                $familyMember->name = $data['child_name'];
                $familyMember->relationship = 'Children';
                $familyMember->gender = '---';

                if (!empty($data["child_dob"])) {
                    $child_dob = $data["child_dob"];
                    $familyMember->dob = $this->getdateFormatForDb($child_dob, $user_id);
                }
                $familyMember->save();
            }

            //save compensatory data of employee
            $compensatory = Compensatory::where('user_id', $user_id);

            if ($compensatory->exists()) {
                $compensatory = $compensatory->first();
            } else {
                $compensatory = new Compensatory;
            }
            $compensatory->user_id = $user_id;
            $compensatory->basic = $data["basic"] ?? '';
            $compensatory->hra = $data["hra"] ?? '';
            $compensatory->Statutory_bonus = $data["statutory_bonus"] ?? '';
            $compensatory->child_education_allowance = $data["child_education_allowance"] ?? '';
            $compensatory->food_coupon = $data["food_coupon"] ?? '';
            $compensatory->lta = $data["lta"] ?? '';
            $compensatory->special_allowance = $data["special_allowance"] ?? '';
            $compensatory->other_allowance = $data["other_allowance"] ?? '';
            $compensatory->gross = $data["gross"] ?? '';
            $compensatory->epf_employer_contribution = $data["epf_employer_contribution"] ?? '';
            $compensatory->esic_employer_contribution = $data["esic_employer_contribution"] ?? '';
            $compensatory->insurance = $data["insurance"] ?? '';
            $compensatory->graduity = $data["graduity"] ?? '';
            $compensatory->cic = $data["ctc"] ?? '';
            $compensatory->epf_employee_contribution = $data["epf_employee"] ?? '';
            $compensatory->esic_employee = $data["esic_employee"] ?? '';
            $compensatory->professional_tax = $data["professional_tax"] ?? '';
            $compensatory->labour_welfare_fund = $data["labour_welfare_fund"] ?? '';
            $compensatory->net_income = $data["net_income"] ?? '';
            $compensatory->save();

            //save the onboard documents
            if ($onboard_type == 'normal' || $onboard_type == 'quick') {
                $this->uploadDocument($user_id, $data['Aadharfront'], 'Aadhar Card Front');
                $this->uploadDocument($user_id, $data['AadharBack'], 'Aadhar Card Back');
                $this->uploadDocument($user_id, $data['panDoc'], 'Pan Card');
                $this->uploadDocument($user_id, $data['passport'], 'Passport');
                $this->uploadDocument($user_id, $data['voterId'], 'Voter ID');
                $this->uploadDocument($user_id, $data['dlDoc'], 'Driving License');
                $this->uploadDocument($user_id, $data['eductionDoc'], 'Education Certificate');
                $this->uploadDocument($user_id, $data['releivingDoc'], 'Relieving Letter');
            }
            return $response = ([
                'status' => 'success',
                'message' => 'Employee details saved successfully',
                'data' => ''
            ]);
        } catch (\Exception $e) {

            return $response = ([
                'status' => 'failure',
                'message' => 'Error while saving record ',
                'data' => $e->getMessage() . "  " . $e->getline()

            ]);
        }
    }

    public function Save_Employee_QuickOnboard_Data($data, $user_data, $onboard_type)
    {

        try {

            $user_id = $user_data->id;

            $newEmployee = VmtEmployee::where('userid', $user_id);

            if ($newEmployee->exists()) {
                $newEmployee = $newEmployee->first();
            } else {
                $newEmployee = new VmtEmployee;
            }

            $dob = $data["dob"] ?? '';
            $doj = $data["doj"] ?? '';
            $passport_date = $data["passport_date"] ?? '';

            $newEmployee->userid = $user_id;
            $newEmployee->marital_status_id = $data["marital_status"] ?? '';
            //$newEmployee->dob   =  $dob ? $this->getdateFormatForDb($dob, $user_id) : '';
            $newEmployee->doj = $doj ? $this->getdateFormatForDb($doj, $user_id) : '';
            // $newEmployee->dol   =  $doj ? $this->getdateFormatForDb($doj, $user_id) : '';
            $newEmployee->gender = $data["gender"] ?? '';
            $data_mobile_number = empty($data["mobile_number"]) ? "" : strval($data["mobile_number"]);
            $newEmployee->mobile_number = $data_mobile_number;
            $newEmployee->aadhar_number = $data["aadhar_number"] ?? '';
            $newEmployee->pan_number = isset($data["pan_number"]) ? ($data["pan_number"]) : " ";
            $newEmployee->dl_no = $data["dl_no"] ?? '';
            $newEmployee->nationality = $data["nationality"] ?? '';
            $newEmployee->passport_number = $data["passport_no"] ?? '';
            $newEmployee->passport_date = $passport_date ? $this->getdateFormatForDb($passport_date, $user_id) : '';
            //$newEmployee->pan_ack   =    $data["pan_ack"];
            $newEmployee->location = $data["work_location"] ?? '';
            $newEmployee->blood_group_id = $data["blood_group_name"] ?? '';
            $newEmployee->physically_challenged = $data["physically_challenged"] ?? 'no';
            $newEmployee->bank_id = $data["bank_id"] ?? '';
            $newEmployee->bank_account_number = $data["AccountNumber"] ?? '';
            $newEmployee->bank_ifsc_code = $data["bank_ifsc"] ?? '';

            //employee address details
            $newEmployee->current_address_line_1 = $data["current_address_line_1"] ?? '';
            $newEmployee->current_address_line_2 = $data["current_address_line_2"] ?? '';
            $newEmployee->permanent_address_line_1 = $data["permanent_address_line_1"] ?? '';
            $newEmployee->permanent_address_line_2 = $data["permanent_address_line_2"] ?? '';
            $newEmployee->current_country_id = $data["current_country"] ?? '';
            $newEmployee->permanent_country_id = $data["permanent_country"] ?? '';
            $newEmployee->current_state_id = $data["current_state"] ?? '';
            $newEmployee->permanent_state_id = $data["permanent_state"] ?? '';
            $newEmployee->current_city = $data["current_city"] ?? '';
            $newEmployee->permanent_city = $data["permanent_city"] ?? '';
            $newEmployee->current_pincode = $data["current_pincode"] ?? '';
            $newEmployee->permanent_pincode = $data["permanent_pincode"] ?? '';
            $newEmployee->no_of_children = $data["no_of_children"] ?? 0;

            $newEmployee->save();
            //save employee office details

            $empOffice = VmtEmployeeOfficeDetails::where('user_id', $user_id);

            if ($empOffice->exists()) {
                $empOffice = $empOffice->first();
            } else {
                $empOffice = new VmtEmployeeOfficeDetails;
            }
            //dd($data);
            $confirmation_period = $data['confirmation_period'] ?? '';
            $empOffice->user_id = $user_id;
            $empOffice->department_id = $data["department"] ?? '';
            $empOffice->process = $data["process"] ?? '';
            $empOffice->designation = $data["designation"] ?? '';
            $empOffice->cost_center = $data["cost_center"] ?? '';
            $empOffice->probation_period = $data['probation_period'] ?? '';
            $empOffice->confirmation_period = $confirmation_period ? $this->getdateFormatForDb($confirmation_period, $user_id) : '';
            $empOffice->holiday_location = $data["holiday_location"] ?? '';
            $empOffice->l1_manager_code = $data["l1_manager_code"] ?? '';
            $l1_manager_name = User::where("user_code", $data["l1_manager_code"])->first();
            if (!empty($l1_manager_name)) {
                $empOffice->l1_manager_name = $l1_manager_name->name;  // => "k"
            }
            $empOffice->work_location = $data["work_location"] ?? '';
            $empOffice->officical_mail = $data["officical_mail"] ?? '';
            $empOffice->official_mobile = $data["official_mobile"] ?? '';
            $empOffice->emp_notice = $data["emp_notice"] ?? '';
            $empOffice->save();

            //assign default workshift to employee

            $emp_workshift = new VmtEmployeeWorkShifts;
            $emp_workshift->user_id = $user_id;
            $work_shift_id = VmtWorkShifts::where('is_default', '1')->first();
            $emp_shift_id = VmtEmployeeWorkShifts::where('user_id', '$user_id')->first();
            if (!empty($work_shift_id)) {
                $emp_workshift->work_shift_id = $work_shift_id->id;
            }
            if (empty($emp_shift_id)) {
                $emp_workshift->is_active = '1';
                $emp_workshift->save();
            }

            //save statutory data of employee

            //save compensatory data of employee
            $compensatory = Compensatory::where('user_id', $user_id);

            if ($compensatory->exists()) {
                $compensatory = $compensatory->first();
            } else {
                $compensatory = new Compensatory;
            }
            $compensatory->user_id = $user_id;
            $compensatory->basic = $data["basic"] ?? '';
            $compensatory->hra = $data["hra"] ?? '';
            $compensatory->Statutory_bonus = $data["statutory_bonus"] ?? '';
            $compensatory->child_education_allowance = $data["child_education_allowance"] ?? '';
            $compensatory->food_coupon = $data["food_coupon"] ?? '';
            $compensatory->lta = $data["lta"] ?? '';
            $compensatory->special_allowance = $data["special_allowance"] ?? '';
            $compensatory->other_allowance = $data["other_allowance"] ?? '';
            $compensatory->gross = $data["gross"] ?? '';
            $compensatory->epf_employer_contribution = $data["epf_employer_contribution"] ?? '';
            $compensatory->esic_employer_contribution = $data["esic_employer_contribution"] ?? '';
            $compensatory->insurance = $data["insurance"] ?? '';
            $compensatory->graduity = $data["graduity"] ?? '';
            $compensatory->cic = $data["ctc"] ?? '';
            $compensatory->epf_employee_contribution = $data["epf_employee"] ?? '';
            $compensatory->esic_employee = $data["esic_employee"] ?? '';
            $compensatory->professional_tax = $data["professional_tax"] ?? '';
            $compensatory->labour_welfare_fund = $data["labour_welfare_fund"] ?? '';
            $compensatory->net_income = $data["net_income"] ?? '';
            $compensatory->save();


            return $response = ([
                'status' => 'success',
                'message' => 'Employee details saved successfully',
                'data' => ''
            ]);
        } catch (\Exception $e) {

            return $response = ([
                'status' => 'failure',
                'message' => 'Error while saving record ',
                'data' => $e->getMessage() . " " . $e->getline()
            ]);
        }
    }


    public function Save_Employee_Bulk_OnboardData($data, $user_data, $onboard_type)
    {

        try {

            $user_id = $user_data->id;
            $newEmployee = VmtEmployee::where('userid', $user_id);

            if ($newEmployee->exists()) {
                $newEmployee = $newEmployee->first();
            } else {
                $newEmployee = new VmtEmployee;
            }

            $doj = $data["doj"] ?? '';
            $dob = $data["dob"] ?? '';

            $newEmployee->userid = $user_id;
            $newEmployee->gender = $data["gender"] ?? '';
            $newEmployee->location = $data["location"] ?? '';
            $newEmployee->doj = $doj ? $this->getdateFormatForDb($doj, $user_id) : '';
            // $newEmployee->dol   =  $doj ? $this->getdateFormatForDb($doj, $user_id) : '';
            $newEmployee->dob = $dob ? $this->getdateFormatForDb($dob, $user_id) : '';
            // $newEmployee->location   =    $data["work_location"] ?? '';
            $newEmployee->pan_number = isset($data["pan_no"]) ? ($data["pan_no"]) : "PANNOTAVBL";
            $newEmployee->aadhar_number = $data["aadhar"] ?? '';

            if (!empty($data["marital_status"])) {
                $marital_status_id = VmtMaritalStatus::where('name', ucfirst(trim($data["marital_status"])))->first()->id; // to get marital status id
                $newEmployee->marital_status_id = $marital_status_id ?? '';
            }

            if (!empty($data['bank_name'])) {
                $bank_id = Bank::where('bank_name', trim($data['bank_name']))->first()->id;  // to get bank id
                $newEmployee->bank_id = $bank_id ?? '';
            }

            $newEmployee->bank_ifsc_code = $data["bank_ifsc"] ?? '';
            $newEmployee->bank_account_number = $data["account_no"] ?? '';
            $newEmployee->current_address_line_1 = $data["current_address"] ?? '';
            $newEmployee->permanent_address_line_1 = $data["permanent_address"] ?? '';
            $newEmployee->no_of_children = $data["no_of_child"] ?? '';
            $data_mobile_number = empty($data["mobile_number"]) ? "" : strval($data["mobile_number"]);
            $newEmployee->mobile_number = $data_mobile_number;
            $newEmployee->save();

            //store employeeoffice details
            $empOffice = VmtEmployeeOfficeDetails::where('user_id', $user_id);

            if ($empOffice->exists()) {
                $empOffice = $empOffice->first();
            } else {
                $empOffice = new VmtEmployeeOfficeDetails;
            }
            $empOffice->user_id = $user_id; //Link between USERS and VmtEmployeeOfficeDetails table
            if (!empty($data['department'])) {
                $department_id = Department::where('name', strtolower(trim($data['department'])))->first()->id;
                $empOffice->department_id = $department_id ?? ''; // => "lk"
            }
            $empOffice->process = $data["process"] ?? ''; // => "k"
            $empOffice->designation = $data["designation"] ?? ''; // => "k"
            $empOffice->cost_center = $data["cost_center"] ?? '';
            $empOffice->confirmation_period = $data['confirmation_period'] ?? '';
            $empOffice->holiday_location = $data["holiday_location"] ?? ''; // => "k"
            $empOffice->l1_manager_code = $data["l1_manager_code"] ?? ''; // => "k"
            $l1_manager_name = User::where("user_code", $data["l1_manager_code"])->first();
            if (!empty($l1_manager_name)) {
                $empOffice->l1_manager_name = $l1_manager_name->name;  // => "k"
            }
            $empOffice->officical_mail = $data["official_mail"] ?? ''; // => "k@k.in"
            $empOffice->work_location = $data["work_location"] ?? ''; // => "k"
            $empOffice->official_mobile = $data["official_mobile"] ?? ''; // => "1234567890"
            $empOffice->emp_notice = $data["emp_notice"] ?? ''; // => "0"
            $empOffice->save();

            //assign default workshift to employee

            $emp_workshift = new VmtEmployeeWorkShifts;
            $emp_workshift->user_id = $user_id;
            $work_shift_id = VmtWorkShifts::where('is_default', '1')->first();
            $emp_shift_id = VmtEmployeeWorkShifts::where('user_id', '$user_id')->first();

            if (!empty($work_shift_id)) {
                $emp_workshift->work_shift_id = $work_shift_id->id;
            }
            if (empty($emp_shift_id)) {
                $emp_workshift->is_active = '1';
                $emp_workshift->save();
            }

            //store employee_statutoryDetails details

            $newEmployee_statutoryDetails = VmtEmployeeStatutoryDetails::where('user_id', $user_id);

            if ($newEmployee_statutoryDetails->exists()) {
                $newEmployee_statutoryDetails = $newEmployee_statutoryDetails->first();
            } else {
                $newEmployee_statutoryDetails = new VmtEmployeeStatutoryDetails;
            }
            $newEmployee_statutoryDetails->user_id = $user_id;
            $newEmployee_statutoryDetails->uan_number = $data["uan_number"] ?? '';
            $newEmployee_statutoryDetails->epf_number = $data["epf_number"] ?? '';
            $newEmployee_statutoryDetails->esic_number = $data["esic_number"] ?? '';
            $newEmployee_statutoryDetails->pf_applicable = $data["pf_applicable"] ?? '';
            $newEmployee_statutoryDetails->esic_applicable = $data["esic_applicable"] ?? '';
            $newEmployee_statutoryDetails->ptax_location_state_id = $data["ptax_location"] ?? '';
            $newEmployee_statutoryDetails->tax_regime = $data["tax_regime"] ?? '';
            $newEmployee_statutoryDetails->lwf_location_state_id = $data["lwf_location"] ?? '';
            $newEmployee_statutoryDetails->save();

            //store employee_familyDetails details

            VmtEmployeeFamilyDetails::where('user_id', $user_id)->delete();

            if (!empty($data['father_name'])) {

                $familyMember = new VmtEmployeeFamilyDetails;
                $familyMember->user_id = $user_id;
                $familyMember->name = $data['father_name'];
                $familyMember->relationship = 'Father';
                $familyMember->gender = 'Male';
                if (!empty($data["father_dob"])) {
                    $dob_father = $data["father_dob"];
                    $familyMember->dob = $this->getdateFormatForDb($dob_father, $user_id);
                }
                $familyMember->save();
            }

            if (!empty($data['mother_name'])) {
                $familyMember = new VmtEmployeeFamilyDetails;
                $familyMember->user_id = $user_id;
                $familyMember->name = $data['mother_name'];
                $familyMember->relationship = 'Mother';
                $familyMember->gender = 'Female';
                //for bulk onboarding
                if (!empty($data["mother_dob"])) {
                    $dob_mother = $data["mother_dob"];
                    $familyMember->dob = $this->getdateFormatForDb($dob_mother, $user_id);
                }
                $familyMember->save();
            }


            if ((strtolower($data['marital_status'])) == 'Married') {
                $familyMember = new VmtEmployeeFamilyDetails;
                $familyMember->user_id = $user_id;
                $familyMember->name = $data['spouse_name'] ?? " ";
                $familyMember->relationship = 'Spouse';

                if (!empty($data['gender'] == 'Male')) {
                    $familyMember->gender = 'Female';
                } else {
                    $familyMember->gender = 'Male';
                }
                // for bulk onboarding
                if (!empty($data["spouse_dob"])) {
                    $dob_spouse = $data["spouse_dob"];
                    $familyMember->dob = $this->getdateFormatForDb($dob_spouse, $user_id);
                }

                $familyMember->save();
            }

            if (!empty($data['child_name'])) {
                $familyMember = new VmtEmployeeFamilyDetails;
                $familyMember->user_id = $user_id;
                $familyMember->name = $data['child_name'];
                $familyMember->relationship = 'Children';
                $familyMember->gender = '---';

                if (!empty($data["child_dob"]))
                    $familyMember->dob = $data["child_dob"];
                //   $familyMember->dob = $this->getdateFormatForDb($child_dob) ;
                $familyMember->save();
            }



            //store employee_compensatory Details details

            $compensatory = Compensatory::where('user_id', $user_id);

            if ($compensatory->exists()) {
                $compensatory = $compensatory->first();
            } else {
                $compensatory = new Compensatory;
            }

            $compensatory->user_id = $user_id;
            $compensatory->basic = $data["basic"] ?? '';
            $compensatory->hra = $data["hra"] ?? '';
            $compensatory->Statutory_bonus = $data["statutory_bonus"] ?? '';
            $compensatory->child_education_allowance = $data["child_education_allowance"] ?? '';
            $compensatory->food_coupon = $data["food_coupon"] ?? '';
            $compensatory->lta = $data["lta"] ?? '';
            $compensatory->special_allowance = $data["special_allowance"] ?? '';
            $compensatory->other_allowance = $data["other_allowance"] ?? '';
            $compensatory->gross = $data["gross"] ?? '';
            $compensatory->epf_employer_contribution = $data["epf_employer_contribution"] ?? '';
            $compensatory->esic_employer_contribution = $data["esic_employer_contribution"] ?? '';
            $compensatory->insurance = $data["insurance"] ?? '';
            $compensatory->graduity = $data["graduity"] ?? '';
            $compensatory->dearness_allowance = $data["dearness_allowance"] ?? '';
            $compensatory->cic = $data["ctc"] ?? '';
            $compensatory->epf_employee_contribution = $data["epf_employee"] ?? '';
            $compensatory->esic_employee = $data["esic_employee"] ?? '';
            $compensatory->professional_tax = $data["professional_tax"] ?? '';
            $compensatory->labour_welfare_fund = $data["labour_welfare_fund"] ?? '';
            $compensatory->net_income = $data["net_income"] ?? '';
            $compensatory->save();

            return $response = ([
                'status' => 'success',
                'message' => 'Employee details saved successfully',
                'data' => ''
            ]);
        } catch (\Exception $e) {

            return $response = ([
                'status' => 'failure',
                'message' => 'Error while saving record ',
                'data' => $e->getMessage() . " " . $e->getline() . " " . $e->getFile()

            ]);
        }
    }


    public function uploadDocument($emp_id, $fileObject, $onboard_document_type)
    {

        try {

            if (!empty($fileObject)) {
                $emp_code = User::find($emp_id)->user_code;

                $onboard_doc_id = VmtDocuments::where('document_name', $onboard_document_type);

                if ($onboard_doc_id->exists()) {
                    $onboard_doc_id = $onboard_doc_id->first()->id;

                } else
                    return null;

                $employee_documents = VmtEmployeeDocuments::where('user_id', $emp_id)->where('doc_id', $onboard_doc_id);

                //check if document already uploaded
                if ($employee_documents->exists()) {

                    $employee_documents = $employee_documents->first();

                    $file_path = '/' . $emp_code . '/onboarding_documents' . '/' . $employee_documents->doc_url;

                    //fetch the existing document and delete its file from STORAGE folder
                    $file_exists_status = Storage::disk('private')->exists($file_path);
                    if ($file_exists_status) {

                        //delete the file
                        Storage::disk('private')->delete($file_path);
                    }
                } else {
                    $employee_documents = new VmtEmployeeDocuments;
                    $employee_documents->user_id = $emp_id;
                    $employee_documents->doc_id = $onboard_doc_id;
                }


                $date = date('d-m-Y_H-i-s');
                $fileName = str_replace(' ', '', $onboard_document_type) . '_' . $emp_code . '_' . $date . '.' . $fileObject->extension();
                $path = $emp_code . '/onboarding_documents';
                $filePath = $fileObject->storeAs($path, $fileName, 'private');
                $employee_documents->doc_url = $fileName;

                $employee_documents_status = VmtEmployeeDocuments::where('user_id', $emp_id)
                    ->where('doc_id', $onboard_doc_id);

                if ($employee_documents_status->exists()) {
                    $employee_documents_status = $employee_documents_status->first()->status;
                    if ($employee_documents_status == 'Approved')
                        $employee_documents->status = $employee_documents_status;
                    else {
                        $employee_documents->status = 'Pending';
                    }
                } else {

                    $employee_documents->status = 'Pending';

                }


                $employee_documents->save();
            }
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => '',
                'data' => "Error while saving record : " . $e->getMessage()
            ]);
        }

        return "success";
    }

    public function deleteEmployee($user_id)
    {
        $user_data = User::find($user_id);

        if (!empty($user_data)) {
            $user_data->delete();
        }

        $emp_details = VmtEmployee::find($user_id);

        if (!empty($emp_details)) {
            $emp_details->delete();
        }

        $emp_office_details = VmtEmployeeOfficeDetails::find($user_id);

        if (!empty($emp_office_details)) {
            $emp_office_details->delete();
        }

        $emp_statutory_details = VmtEmployeeStatutoryDetails::find($user_id);

        if (!empty($emp_statutory_details)) {
            $emp_statutory_details->delete();
        }

        $emp_compensatory_details = Compensatory::find($user_id);
        if (!empty($emp_compensatory_details)) {
            $emp_compensatory_details->delete();
        }
        return 'failure';
    }
    private function getdateFormatForDb($date, $user_id)
    {

        try {
            $processed_date = null;
            //Check if its in proper format
            $processed_date_one = \DateTime::createFromFormat('d-m-Y', $date);
            $processed_date_three = \DateTime::createFromFormat('Y-m-d', $date);
            $processed_date_two = \DateTime::createFromFormat('d/m/Y', $date);

            //If date is in 'd-m-y' format, then convert into one
            if ($processed_date_one) {
                //Then convert to Y-m-d
                $processed_date = $processed_date_one->format('Y-m-d');
            } else if (!empty($processed_date_two)) {

                $processed_date = $processed_date_two->format('Y-m-d');
            } else if ($processed_date_three) {

                $processed_date = $processed_date_three->format('Y-m-d');
            } else {
                $processed_date = '';
            }


            return $processed_date;
        } catch (\InvalidArgumentException $e) {

            return $response = ([
                'status' => 'failure',
                'message' => 'Not a date',
                'data' => "Error for input date : " . $e->getMessage()
            ]);
        }
    }

    public function viewDocument($fileObject, $emp_code, $filename)
    {
    }

    public function downloadDocument($fileObject, $emp_code, $filename)
    {
    }


    // Generate Employee Appointment PDF after onboarding
    public function attachAppointmentLetterPDF($employeeData, $onboard_type)
    {
        $empNameString = $employeeData['employee_name'];
        $filename = 'appoinment_letter_' . $empNameString . '_' . time() . '.pdf';
        $data = $employeeData;
        // $gross =$employeeData["basic"] + $employeeData["hra"] + $employeeData["statutory_bonus"] + $employeeData["child_education_allowance"] + $employeeData["food_coupon"] + $employeeData["lta"] + $employeeData["special_allowance"] + $employeeData["other_allowance"];
        $data['basic_monthly'] = $employeeData['basic'];
        $data['basic_yearly'] = intval($employeeData['basic']) * 12;
        $data['hra_monthly'] = $employeeData['hra'];
        $data['hra_yearly'] = intval($employeeData['hra']) * 12;
        $data['spl_allowance_monthly'] = $employeeData['special_allowance'];
        $data['spl_allowance_yearly'] = intval($employeeData['special_allowance']) * 12;
        $data['gross_monthly'] = $employeeData["gross"];
        $data['gross_yearly'] = intval($employeeData["gross"]) * 12;
        $data['employer_epf_monthly'] = $employeeData['epf_employer_contribution'];
        $data['employer_epf_yearly'] = intval($employeeData['epf_employer_contribution']) * 12;
        $data['employer_esi_monthly'] = $employeeData['esic_employer_contribution'];
        $data['employer_esi_yearly'] = intval($employeeData['esic_employer_contribution']) * 12;
        $data['CEA_monthly'] = $employeeData["child_education_allowance"] ?? "0";
        $data['CEA_yearly'] = intval($employeeData["child_education_allowance"] ?? "0") * 12;
        $data['food_coupon_monthly'] = $employeeData['food_coupon'] ?? "0";
        $data['food_coupon_yearly'] = intval($employeeData['lta'] ?? "0") * 12;
        $data['lta_monthly'] = $employeeData['lta'] ?? "0";
        $data['lta_yearly'] = intval($employeeData['lta'] ?? "0") * 12;
        if ($onboard_type == 'normal') {
            $data['ctc_monthly'] = $employeeData['cic'];
            $data['ctc_yearly'] = intval($employeeData['cic']) * 12;
        } else {
            $data['ctc_monthly'] = $employeeData['ctc'];
            $data['ctc_yearly'] = intval($employeeData['ctc']) * 12;
        }
        $data['employee_epf_monthly'] = $employeeData["epf_employee"];
        $data['employee_epf_yearly'] = intval($employeeData["epf_employee"]) * 12;
        $data['employee_esi_monthly'] = $employeeData["esic_employee"];
        $data['employee_esi_yearly'] = intval($employeeData["esic_employee"]) * 12;
        $data['employer_pt_monthly'] = $employeeData["professional_tax"] ?? "0";
        $data['employer_pt_yearly'] = $employeeData["professional_tax"] ? intval($employeeData["professional_tax"]) * 12 : "0";
        $data['net_take_home_monthly'] = $employeeData["net_income"];
        $data['net_take_home_yearly'] = intval($employeeData["net_income"]) * 12;
        if ($onboard_type == 'normal') {
            $data["ctc_in_words"] = numberToWord(intval($employeeData['cic']) * 12);

        } else {
            $data["ctc_in_words"] = numberToWord(intval($employeeData['ctc']) * 12);
        }
        $data["ctc_in_words"] = str_replace("  ", " ", $data["ctc_in_words"]);

        $fetchMasterConfigValue = VmtMasterConfig::where("config_name", "can_send_appointmentletter_after_onboarding")->first();

        // if ($fetchMasterConfigValue['config_value'] == "true") {

        $query_client = VmtClientMaster::find(session('client_id'));

        $client_full_name = $query_client->client_fullname;

        $client_name = strtolower(str_replace(' ', '_', $client_full_name));

        $appointment_letter_name = $this->getAppointmentletterName($client_name);

        $html = view($appointment_letter_name, $data);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $pdf = new Dompdf($options);
        $pdf->loadhtml($html, 'UTF-8');
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $docUploads = $pdf->output();
        $client_id = sessionGetSelectedClientid();

        $VmtClientMaster = VmtClientMaster::where("id", $client_id)->first();
        $image_view = url('/') . $VmtClientMaster->client_logo;

        // dd( $docUploads);
        $filename = 'appoinment_letter_' . $data['employee_name'] . '_' . time() . '.pdf';
        $file_path = public_path('appoinmentLetter/' . $filename);
        file_put_contents($file_path, $docUploads);
        $appoinmentPath = public_path('appoinmentLetter/') . $filename;


        $isSent = \Mail::to($data['email'])->send(new WelcomeMail($data['employee_code'], 'Abs@123123', request()->getSchemeAndHttpHost(), $appoinmentPath, $image_view, $VmtClientMaster->client_code));
        return $isSent;
        //}
    }


    public function getAppointmentletterName($client_name)
    {
        try {

            $appointment_letter_name = "";

            if ($client_name == "indchem_marketing_agencies") {

                $appointment_letter_name = "appointment_mail_templates.appointment_Letter_Indchem_Marketing_Agencies";

            }
            if ($client_name == "langro_india_private_limited") {

                $appointment_letter_name = "appointment_mail_templates.appointment_letter_langro_india_pvt_ltd";

            }
            if ($client_name == "priti_sales_corporations") {

                $appointment_letter_name = "appointment_mail_templates.appointment_Letter_priti_sales_corporation";

            }
            if ($client_name == "ardens_business_solutions_private_limited") {

                $appointment_letter_name = "appointment_mail_templates.appointmentletter_ardensbusinesssolutionsprivatelimited";

            }

            return $appointment_letter_name;

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "",
                'data' => $e->getmessage(),
            ]);
        }
    }
    public function isUserExist($t_emp_code)
    {
        if (empty(User::where('user_code', $t_emp_code)->where('is_ssa', '0')->first()))
            return false;
        else
            return true;
    }



    public function getQuickOnboardedEmployeeData($user_id)
    {

        $query_emp_details = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
            ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
            ->join('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'users.id')
            ->where('users.id', '=', $user_id)
            ->first();

        return $query_emp_details;
    }

    /*

        Fetch all the documents uploaded by the employees.




    */
    public function fetchAllEmployeesDocumentsAsGroups(Request $request)
    {
        try {

            $json_response = array();

            $client_id = null;

            if (session('client_id')) {

                if (session('client_id') == 1) {
                    $client_id = VmtClientMaster::pluck('id');
                } else {
                    $client_id = [session('client_id')];
                }

            } else {
                $client_id = [auth()->user()->client_id];
            }

            //Get all the  doc for the given user_id
            $query_pending_onboard_docs = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                ->leftjoin('vmt_employee_documents', 'vmt_employee_documents.user_id', '=', 'users.id')
                ->leftjoin('vmt_documents', 'vmt_documents.id', '=', 'vmt_employee_documents.doc_id')
                ->where('vmt_employee_documents.status', "Pending")
                ->where('users.is_ssa', "0")
                ->whereIn('users.client_id', $client_id)
                ->where('users.is_onboarded', "1")
                ->where('users.active', '<>', "-1")
                ->get([
                    'users.id as user_id',
                    'users.name as name',
                    'vmt_employee_details.doj as doj',
                    'users.user_code as user_code',
                    'vmt_documents.document_name as doc_name',
                    'vmt_employee_documents.id as record_id',
                    'vmt_employee_documents.status as doc_status',
                    'vmt_employee_documents.doc_url as doc_url'
                ]);


            // //store all the documents in single key
            foreach ($query_pending_onboard_docs as $single_pending_docs) {

                $user_code = $single_pending_docs->user_code;

                if (array_key_exists($user_code, $json_response)) {
                    array_push($json_response[$user_code]["documents"], [
                        "record_id" => $single_pending_docs->record_id,
                        "doc_name" => $single_pending_docs->doc_name,
                        "doc_url" => $single_pending_docs->doc_url,
                        "doc_status" => $single_pending_docs->doc_status
                    ]);
                } else {
                    $user_details = [
                        "name" => $single_pending_docs->name,
                        "user_code" => $single_pending_docs->user_code,
                        "doj" => $single_pending_docs->doj,
                        "emp_avatar" => getEmployeeAvatarOrShortName($single_pending_docs->user_id),
                        "documents" => array(
                            [
                                "record_id" => $single_pending_docs->record_id,
                                "doc_name" => $single_pending_docs->doc_name,
                                "doc_url" => $single_pending_docs->doc_url,
                                "doc_status" => $single_pending_docs->doc_status
                            ]
                        ),
                    ];

                    $json_response[$user_code] = $user_details;
                    //array_push(, $user_details);
                }
            }
            return array_values($json_response);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "",
                'data' => $e->getmessage()
            ]);
        }

    }
    public function fetchAllEmployeesDocumentsProof(Request $request)
    {

        $client_id = null;

        if (session('client_id')) {

            if (session('client_id') == 1) {
                $client_id = VmtClientMaster::pluck('id');
            } else {
                $client_id = [session('client_id')];
            }

        } else {
            $client_id = [auth()->user()->client_id];
        }
        $json_response = array();

        //Get all the  doc for the given user_id
        $query_pending_onboard_docs = User::leftjoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
            ->leftjoin('vmt_temp_employee_proof_documents', 'vmt_temp_employee_proof_documents.user_id', '=', 'users.id')
            ->leftjoin('vmt_documents', 'vmt_documents.id', '=', 'vmt_temp_employee_proof_documents.doc_id')
            ->where('vmt_temp_employee_proof_documents.status', "Pending")
            ->whereIn('users.client_id', $client_id)
            ->where('users.is_ssa', "0")
            ->where('users.is_onboarded', "1")
            ->where('users.active', '<>', "-1")
            ->where('vmt_temp_employee_proof_documents.status', '<>', "Approved")
            ->get([
                'users.name as name',
                'users.avatar as avatar',
                'vmt_employee_details.doj as doj',
                'users.user_code as user_code',
                'users.id as id',
                'vmt_documents.document_name as doc_name',
                'vmt_temp_employee_proof_documents.id as record_id',
                'vmt_temp_employee_proof_documents.status as doc_status',
                'vmt_temp_employee_proof_documents.doc_url as doc_url'
            ]);

        // //store all the documents in single key
        foreach ($query_pending_onboard_docs as $key => $single_pending_docs) {

            $user_code = $single_pending_docs->user_code;

            if (array_key_exists($user_code, $json_response)) {

                $query_pending_onboard_docs[$key]["avatar"] = getEmployeeAvatarOrShortName($single_pending_docs->id);
                array_push($json_response[$user_code]["documents"], [
                    "record_id" => $single_pending_docs->record_id,
                    "doc_name" => $single_pending_docs->doc_name,
                    "doc_url" => $single_pending_docs->doc_url,
                    "doc_status" => $single_pending_docs->doc_status,


                ]);
            } else {

                $user_details = [
                    "name" => $single_pending_docs->name,
                    "user_code" => $single_pending_docs->user_code,
                    "doj" => $single_pending_docs->doj,
                    "avatar" => getEmployeeAvatarOrShortName($single_pending_docs->id),
                    "documents" => array(
                        [
                            "record_id" => $single_pending_docs->record_id,
                            "doc_name" => $single_pending_docs->doc_name,
                            "doc_url" => $single_pending_docs->doc_url,
                            "doc_status" => $single_pending_docs->doc_status,

                        ]
                    ),
                ];

                $json_response[$user_code] = $user_details;
                //array_push(, $user_details);
            }
        }


        return array_values($json_response);
    }


    public function updateEmployeeActiveStatus($user_code, $active_status)
    {

        //Validate
        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'active_status' => $active_status
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                'active_status' => 'required',
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


        $query_user = User::where('user_code', $user_code)->first();

        if (!empty($query_user)) {
            $query_user->active = $active_status;
            $query_user->save();
            return response()->json([
                'status' => 'success',
                'message' => "user activate successfully",
                'mail_status' => ''
            ]);
        } else {
            return response()->json([
                'status' => 'failure',
                'message' => "User not found"
            ]);
        }
    }

    public function getEmployeeRole($user_code)
    {
        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
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

            $response = User::join('vmt_org_roles', 'vmt_org_roles.id', '=', 'users.org_role')
                ->where('users.user_code', $user_code)
                ->get(['vmt_org_roles.name as role'])
                ->first();

            return response()->json([
                'status' => 'success',
                'message' => "",
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ getEmployeeRole() ] ",
                'data' => $e
            ]);
        }
    }
    public function updateMasterConfigClientCode($client_id)
    {
        $validator = Validator::make(
            $data = [
                'client_id' => $client_id,
            ],
            $rules = [
                "client_id" => 'required|exists:vmt_client_master,id',
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

            $client_data = VmtClientMaster::where('id', $client_id)->first();

            $update_master_config = VmtMasterConfig::where('config_name', 'employee_code_prefix')->first();
            $update_master_config->config_value = $client_data->client_code;
            $update_master_config->save();


            return response()->json([
                'status' => 'success',
                'message' => "client code updated successfully",
                'data' => $update_master_config
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "",
                'data' => $e->getmessage()
            ]);
        }
    }

    public function getAllDropdownFilters()
    {
        try {
            $marital_details = VmtMaritalStatus::get();
            $blood_groups = VmtBloodGroup::get();
            $bank_details = Bank::get();
            $country_details = Countries::get();
            $state_details = State::get();
            $department = Department::get();
            $manager_details = User::where('org_role', 4)->get(['user_code', 'name']);
            $document_type = VmtDocuments::where('is_mandatory', 1)->get();
            return response()->json([
                'status' => 'success',
                'data' => [
                    'martial_details' => $marital_details,
                    'blood_group' => $blood_groups,
                    'bank_details' => $bank_details,
                    'country_details' => $country_details,
                    'state_details' => $state_details,
                    'department' => $department,
                    'manager_details' => $manager_details,
                    'event_type' => ['work-anniversary', 'birthday'],
                    'gender' => ['male', 'female', 'others'],
                    'relationship_type' => ['father', 'mother', 'spouse', 'son', 'daughter', 'sibling'],
                    'document_type' => $document_type
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'error' => $e->getMessage(),
                'error_line' => $e->getTraceAsString()
            ]);
        }
    }

    public function saveEmployeeOnboardingPersonalDetails_Mobile($user_code,$employee_name,$email,$marital_status,$dob,$doj,$gender,$mobile_number,$aadhar_number,$pan_number,$dl_number,$nationality,$blood_group)
    {

        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'employee_name' => $employee_name,
                'email' => $email,
                'marital_status' => $marital_status,
                'doj' => $doj,
                'gender' => $gender,
                'dob' => $dob,
                'mobile_number' => $mobile_number,
                'aadhar_number' => $aadhar_number,
                'pan_number' => $pan_number,
                'dl_number' => $dl_number,
                'nationality' => $nationality,
                'blood_group' => $blood_group,
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "employee_name" => 'required',
                "email" => 'required',
                "marital_status" => 'required',
                "dob" => 'required|date',
                "doj" => 'required|date',
                "gender" => 'required',
                "mobile_number" => 'required|numeric',
                "aadhar_number" => 'required|numeric',
                "pan_number" => 'required',
                "dl_number" => 'required',
                "nationality" => 'required',
                "blood_group" => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'date' => 'Field :attribute is invalid',
                'numeric' => 'Field :attribute should be numeric',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        try {


            $save_user_details = User::where('user_code',$user_code);

            if(!empty($save_user_details->exists() ))
            {
                $save_user_details = $save_user_details->first();
                $message="Employee personal detials updated successfully";

            }else{
                $save_user_details = new User;
                $message="Employee personal detials saved successfully";
            }

            $save_user_details->user_code=$user_code;
            $save_user_details->name=$employee_name;
            $save_user_details->email=$email;
            $save_user_details->save();

            $user_id =$save_user_details->id;

            $save_personal_details = VmtEmployee::where('userid', $user_id);

            if(!empty($save_personal_details->exists() ))
            {
                $save_personal_details = $save_personal_details->first();

                $message="Employee personal detials updated successfully";

            }else{
                $save_personal_details = new VmtEmployee;
                $save_personal_details->user_id  = $user_id ;
                $message="Employee personal detials saved successfully";
            }


            $marital_status_detail =VmtMaritalStatus::where('name',ucfirst($marital_status))->first();
            $blood_group_detail =VmtBloodGroup::where('name',ucfirst($blood_group))->first();

            $save_personal_details->marital_status_id  = $marital_status_detail->id;
            $save_personal_details->dob = $dob ? $this->getdateFormatForDb($dob, $user_id) : '';
            $save_personal_details->doj = $doj ? $this->getdateFormatForDb($doj, $user_id) : '';
            $save_personal_details->gender= ucfirst($gender) ;
            $save_personal_details->mobile_number= $mobile_number;
            $save_personal_details->aadhar_number= $aadhar_number;
            $save_personal_details->pan_number = $pan_number;
            $save_personal_details->dl_no = $dl_number;
            $save_personal_details->nationality  = $nationality;
            $save_personal_details->blood_group_id= $blood_group_detail->id;
            $save_personal_details->save();



            return response()->json([
                'status' => 'success',
                'message' =>$message,
                'data' => ''
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "",
                'data' => $e->getmessage() .' Line'. $e->getline()
            ]);
        }
    }
    public function saveEmployeeOnboardingBankDetails_Mobile($user_code,$payment_mode,$bank_name,$bank_account_number,$bank_ifsc_code)
    {
        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'payment_mode' => $payment_mode,
                'bank_name' => $bank_name,
                'bank_account_number' => $bank_account_number,
                'bank_ifsc_code' => $bank_ifsc_code,

            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "payment_mode" => 'required',
                "bank_name" => 'required|exists:vmt_banks,bank_name',
                "bank_account_number" => 'required|numeric',
                "bank_ifsc_code" => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'date' => 'Field :attribute is invalid',
                'numeric' => 'Field :attribute should be numeric',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        try {

            $user_id = User::where('user_code',$user_code)->first()->id;

            $save_bank_details = VmtEmployee::where('userid', $user_id);

            if(!empty($save_bank_details->exists() ))
            {
                $save_bank_details = $save_bank_details->first();

                $message="Employee bank detials updated successfully";

            }else{
                $save_bank_details = new VmtEmployee;
                $save_bank_details->user_id  = $user_id ;
                $message="Employee bank detials saved successfully";
            }

            $bank_details=Bank::where('bank_name',strtolower($bank_name))->first();

            $save_bank_details->salary_payment_mode  =$payment_mode;
            $save_bank_details->bank_id =$bank_details->id ;
            $save_bank_details->bank_account_number  = $bank_account_number;
            $save_bank_details->bank_ifsc_code  = $bank_ifsc_code;
            $save_bank_details->save();



            return response()->json([
                'status' => 'success',
                'message' =>$message,
                'data' => ''
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "",
                'data' => $e->getmessage()
            ]);
        }
    }
    public function saveEmployeeOnboardingAddressDetails_Mobile( $user_code,$current_address_line_1,$current_address_line_2,$current_country,$current_state,$current_city,$current_pincode,$permanent_address_line_1,$permanent_address_line_2,$permanent_country,$permanent_state,$permanent_city,$permanent_pincode)
    {
        $validator = Validator::make(
            $data = [
           'user_code' =>$user_code,
           'current_address_line_1' =>$current_address_line_1,
           'current_address_line_2' =>$current_address_line_2,
           'current_country' =>$current_country,
           'current_state' =>$current_state,
           'current_city' =>$current_city,
           'current_pincode' =>$current_pincode,
           'permanent_address_line_1' =>$permanent_address_line_1,
           'permanent_address_line_2' =>$permanent_address_line_2,
           'permanent_country' =>$permanent_country,
           'permanent_state' =>$permanent_state,
           'permanent_city' =>$permanent_city,
           'permanent_pincode' =>$permanent_pincode,

            ],
            $rules =[
                'user_code' =>'required|exists:users,user_code',
                'current_address_line_1' =>'required',
                'current_address_line_2' =>'required',
                'current_country' =>'required|exists:vmt_country,country_name',
                'current_state' =>'required|exists:vmt_states,state_name',
                'current_city' =>'required',
                'current_pincode' =>'required',
                'permanent_address_line_1' =>'required',
                'permanent_address_line_2' =>'required',
                'permanent_country' =>'required|exists:vmt_country,country_name',
                'permanent_state' =>'required|exists:vmt_states,state_name',
                'permanent_city' =>'required',
                'permanent_pincode' =>'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'date' => 'Field :attribute is invalid',
                'numeric' => 'Field :attribute should be numeric',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        try {

            $user_id = User::where('user_code',$user_code)->first()->id;

            $save_address_details = VmtEmployee::where('userid', $user_id);

            if(!empty($save_address_details->exists() ))
            {
                $save_address_details = $save_address_details->first();

                $message="Employee address updated successfully";

            }else{
                $save_address_details = new VmtEmployee;
                $save_address_details->user_id  = $user_id ;
                $message="Employee address saved successfully";
            }
            $current_county_details=Countries::where('country_name',$current_country)->first();
            $current_state_details=State::where('state_name',$current_state)->first();
            $permanent_county_details=Countries::where('country_name',$permanent_country)->first();
            $permanent_state_details=State::where('state_name',$permanent_state)->first();

            $save_address_details->current_address_line_1  =$current_address_line_1;
            $save_address_details->current_address_line_2 =$current_address_line_2;
            $save_address_details->current_country_id =$current_county_details->id;
            $save_address_details->current_state_id =$current_state_details->id;
            $save_address_details->current_city =$current_city;
            $save_address_details->current_pincode =$current_pincode;
            $save_address_details->permanent_address_line_1  = $permanent_address_line_1;
            $save_address_details->permanent_address_line_2  = $permanent_address_line_2;
            $save_address_details->permanent_country_id =$permanent_county_details->id;
            $save_address_details->permanent_state_id =$permanent_state_details->id;
            $save_address_details->permanent_city =$permanent_city;
            $save_address_details->permanent_pincode =$permanent_pincode;
            $save_address_details->save();



            return response()->json([
                'status' => 'success',
                'message' =>$message,
                'data' => ''
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "",
                'data' => $e->getmessage()
            ]);
        }
    }
    public function saveEmployeeOnboardingFamilyDetails_Mobile($user_code,$father_name,$father_dob,$father_gender,$father_age,$mother_name,$mother_dob,$mother_gender,$mother_age)
    {

        $validator = Validator::make(
            $data = [
           "user_code"=>$user_code,
           "father_name"=>$father_name,
           "father_dob"=>$father_dob,
           "father_gender"=>$father_gender,
           "father_age"=>$father_age,
           "mother_name"=>$mother_name,
           "mother_dob"=>$mother_dob,
           "mother_gender"=>$mother_gender,
           "mother_age"=>$mother_age,

            ],
            $rules =[
                'user_code' =>'required|exists:users,user_code',
                "father_name"=>"required",
                "father_dob"=>"required",
                "father_gender"=>"required",
                "father_age"=>"required",
                "mother_name"=>"required",
                "mother_dob"=>"required",
                "mother_gender"=>"required",
                "mother_age"=>"required",
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'date' => 'Field :attribute is invalid',
                'numeric' => 'Field :attribute should be numeric',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        try {


            $family_details=array();
            array_push($family_details ,['name'=>$father_name,'dob'=>$father_dob,'gender'=>$father_gender,'age'=>$father_age,'relationship'=>'Father']);
            array_push($family_details ,['name'=>$mother_name,'dob'=>$mother_dob,'gender'=>$mother_gender,'age'=>$mother_age,'relationship'=>'Mother']);


            $user_id = User::where('user_code',$user_code)->first()->id;

        foreach( $family_details as $key=>$single_key){


            $save_family_details = VmtEmployeeFamilyDetails::where('user_id', $user_id)->where('relationship',$single_key['relationship']);

            if(!empty($save_family_details->exists() ))
            {
                $save_family_details = $save_family_details->first();

                $message="Employee family detials updated successfully";

            }else{
                $save_family_details = new VmtEmployeeFamilyDetails;
                $save_family_details->user_id  = $user_id ;
                $message="Employee family detials saved successfully";
            }

            $save_family_details->name  =$single_key['name'];
            $save_family_details->gender =$single_key['gender'];
            $save_family_details->relationship =$single_key['relationship'];
            $save_family_details->dob =$single_key['dob'];
            $save_family_details->save();

        }

            return response()->json([
                'status' => 'success',
                'message' =>$message,
                'data' => ''
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "",
                'data' => $e->getmessage() . ' Line'.$e->getline()
            ]);
        }
    }

    public function getEmployeeOnboardingDetails_Mobile($user_code)
    {
        $validator = Validator::make(
            $data = [

                 "user_code"=>$user_code,

            ],
            $rules =[
                'user_code' =>'required|exists:users,user_code',

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

            $user_id=User::where('user_code',$user_code)->first()->id;
            $query_emp_details  = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
             ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
             ->join('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'users.id')
            ->where('users.user_code', '=', $user_code);

               $response['personal_details']=$query_emp_details->first(["user_code as employee_code","users.name as name","marital_status_id as marital_status","vmt_employee_details.dob","vmt_employee_details.doj","vmt_employee_details.gender",
                                                                               "mobile_number","aadhar_number","pan_number","dl_no as dl_number",
                                                                               "nationality","blood_group_id as blood_group"])->toarray();

               $response['bank_details']=$query_emp_details->clone()->first([ "salary_payment_mode","bank_id" ,"bank_account_number" ,"bank_ifsc_code" ])->toarray();

               $response['address_details']=$query_emp_details->clone()->first(["current_address_line_1","current_address_line_2","current_country_id","current_state_id","current_city",
                                                                           "current_pincode","permanent_address_line_1","permanent_address_line_2","permanent_country_id",
                                                                           "permanent_state_id","permanent_city","permanent_pincode"])->toarray();


               $family_details=VmtEmployeeFamilyDetails::whereIn('user_id',[$user_id] )->get(["name","gender","relationship","dob"])->toarray();
               $response['family_details']=array();
               foreach ($family_details as $fam_key => $single_fam_value) {

                $response['family_details'][$fam_key]= $single_fam_value;

               }

               $response['office_details']=$query_emp_details->clone()->first([ "department_id as department_name","process" ,"designation" ,"cost_center",'work_location',
                                                                              "l1_manager_code as l1_manager_name",'officical_mail','official_mobile','confirmation_period'])->toarray();

                $compensatorty_details = VmtEmployeeCompensatoryDetails::where('user_id', $user_id)->first()->toarray();

                unset($compensatorty_details['id']);
                unset($compensatorty_details['user_id']);
                unset($compensatorty_details['created_at']);
                unset($compensatorty_details['updated_at']);
                unset($compensatorty_details['sal_revision_id']);

                $employee_paygroup_values = array_filter($compensatorty_details, function($value) {
                    return !is_null($value) && $value !== "0" && $value !== 0 && $value !== "" ;
                });

                $format_compensatory_valuse_as_float = array_map(function($value) {
                    return number_format((float)round($value), 2, '.', ',');
                }, $employee_paygroup_values);

                $employee_paygroup_values =$format_compensatory_valuse_as_float;

                  $replace_compensatory_column =VmtPayrollComponents::whereIn('comp_identifier',array_keys($employee_paygroup_values))->get();

                  $get_earnings_data = VmtPayrollComponents::whereIn('comp_identifier', array_keys($employee_paygroup_values))
                                                    ->where('category_id','1')->where('comp_sub_category','1')->pluck('comp_name','comp_identifier')->toarray();

                        $match_earnings_details = array_intersect_key($employee_paygroup_values,$get_earnings_data);

                        $earnings_details = array_combine( $get_earnings_data,$match_earnings_details);

                 $get_contribution_data = VmtPayrollComponents::whereIn('comp_identifier', array_keys($employee_paygroup_values))
                                                    ->where('category_id','2')->where('comp_sub_category','2')->pluck('comp_name','comp_identifier')->toarray();

                        $match_contribution_details = array_intersect_key($employee_paygroup_values,$get_contribution_data);
                        $contibution_details = array_combine( $get_contribution_data,$match_contribution_details);

                 $get_deduction_data = VmtPayrollComponents::whereIn('comp_identifier', array_keys($employee_paygroup_values))
                                                    ->where('category_id','2')->where('comp_sub_category','3')->pluck('comp_name','comp_identifier')->toarray();

                        $match_deduction_details = array_intersect_key($employee_paygroup_values,$get_deduction_data);
                        $deduction_details= array_combine( $get_deduction_data,$match_deduction_details);

                    $response['compensatory_details']['earnings']=$earnings_details;
                    $response['compensatory_details']['contribution']=$contibution_details;
                    $response['compensatory_details']['deduction']=$deduction_details;
                    $response['compensatory_details']['Gross']=$employee_paygroup_values['gross'];
                    $response['compensatory_details']['Net Take Home']=$employee_paygroup_values['net_income'];
                    $response['compensatory_details']['Cost To Company']=$employee_paygroup_values['cic'];

                //check null value

                $employee_doc = VmtEmployeeDocuments::where('user_id', $user_id)->pluck('doc_id');
                $employee_man_doc = VmtDocuments::where('is_mandatory','1')->pluck('id');

                $total_count=count( $response['personal_details'] )+count( $response['bank_details'] )+count( $response['address_details'] )+count( $response['office_details'])+
                count($earnings_details)+
                count($contibution_details)+
                count($deduction_details)+3
                +count( $employee_doc);
                $null_count=0;


                 $null_count=$null_count+(count( $employee_man_doc)-count( $employee_doc));

                foreach ($response as $key => $single_res_values) {
                    $nullcheckdata=$this->hasNullEmptyOrZeroDate( $single_res_values);

                    if($key =='family_details'){
                       $response['is_completed'][$key] =$nullcheckdata['status'];
                        $null_count =$null_count+$nullcheckdata['null_count'];
                    }else{

                       $response['is_completed'][$key] =$nullcheckdata['status'];
                        $null_count =$null_count+$nullcheckdata['null_count'];
                    }

                }
                if(count( $employee_doc) == count( $employee_man_doc)){

                    $response['is_completed']['document_details'] = 1;
                 }else{
                    $response['is_completed']['document_details'] = 0;
                 }


                        foreach($response as $key=>$single_emp_data){

                           foreach ($single_emp_data as $single_key => $single_value) {

                            if( $single_key == 'marital_status'){

                                $marital_status_detail =VmtMaritalStatus::where('id',$single_value)->first();
                                $response[$key][$single_key] =!empty($marital_status_detail)?$marital_status_detail['name']:null;

                            }else if( $single_key == 'blood_group'){

                                $blood_group_detail =VmtBloodGroup::where('id',$single_value)->first();
                                $response[$key][$single_key] =!empty($blood_group_detail)?$blood_group_detail['name']:null;

                            }
                            else if( $single_key == 'bank_id'){

                                $bank_details=Bank::where('id',$single_value)->first();
                                $response[$key][$single_key] =!empty($bank_details)?$bank_details['bank_name']:null;

                            } else if( $single_key == 'current_country_id'){

                                $current_county_details=Countries::where('id',$single_value)->first();

                                $response[$key][$single_key] =!empty($current_county_details)?$current_county_details['country_name']:null;

                            } else if( $single_key == 'current_state_id'){
                                $current_state_details=State::where('id',$single_value)->first();

                                $response[$key][$single_key] =!empty($current_state_details)?$current_state_details['state_name']:null;

                            } else if( $single_key == 'permanent_country_id'){

                                $permanent_county_details=Countries::where('id',$single_value)->first();
                                $response[$key][$single_key] =!empty($permanent_county_details)?$permanent_county_details['country_name']:null;

                            } else if( $single_key == 'permanent_state_id'){

                                $permanent_state_details=State::where('id',$single_value)->first();
                                $response[$key][$single_key] =!empty($permanent_county_details)?$permanent_state_details['state_name']:null;

                            }else if( $single_key == 'department_name'){

                                $department_details=Department::where('id',$single_value)->first();
                                $response[$key]["department_name"] =!empty($department_details)?$department_details['name']:null;

                            }else if( $single_key == 'l1_manager_name'){

                                $manager_details=User::where('user_code',$single_value)->first();
                                $response[$key]['l1_manager_name'] =!empty($manager_details)?$manager_details['name']:null;

                            }
                            else{
                                // dd( $response[$key]);

                                $response[$key][$single_key] =$single_value;
                            }
                         }

                         $percentage = (($total_count-$null_count)/$total_count)*100;
                         $response['is_completed']['percentage']=round($percentage);

                        }

            return response()->json([
                'status' => 'success',
                'message' =>'Data fetch successfully',
                'data' => $response,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "",
                'data' => $e->getmessage() . ' Line'.$e->getline()
            ]);
        }
    }

   public function hasNullEmptyOrZeroDate($array_data) {

        foreach ($array_data as $key=>$single_array_data) {
            $count=0;
            if ($single_array_data == null || $single_array_data == '' || $single_array_data == '0000-00-00') {
                 $count++; // Return 0 if any element is null, empty string, or "0000-00-00"
            }
        }
        if($count !=0){
            return['null_count'=>$count,'status'=>1] ;
        }else{
            return['null_count'=>$count,'status'=>0] ; // Return 1 if none of the elements are null, empty string, or "0000-00-00"
        }

    }

    public function getMandatoryDocumentDetails(Request $request)
    {


        return $response;
    }
    public function getMandatoryDocumentDetails_Mobile()
    {

        try {

            $response = VmtDocuments::where('is_mandatory','1')->get(['id',"document_name"]);

            return $response=([
                'status' => 'success',
                'message' =>'data fetched successfully',
                'data' => $response
            ]);
        } catch (\Exception $e) {

            return $response=([
                'status' => 'failure',
                'message' => "",
                'data' => $e->getmessage() . ' Line'.$e->getline()
            ]);
        }
    }
    public function saveEmployeeOnboardingdocumentDetails_Mobile($user_code,$document_name,$document_object)
    {

        $validator = Validator::make(
            $data = [
               'user_code' =>$user_code,
               'document_name' =>$document_name,
               'document_object' =>$document_object
            ],
            $rules =[
                'user_code' =>'required|exists:users,user_code',
                'document_name' =>'required|exists:vmt_documents,document_name',
                'document_object' =>'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'date' => 'Field :attribute is invalid',
                'numeric' => 'Field :attribute should be numeric',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        try {
            $user_data=User::where('user_code',$user_code)->first();

            $save_Employee_documents = $this->uploadDocument($user_data->id,$document_object,$document_name);


            return $response=([
                'status' => 'success',
                'message' =>'Documents saved successfully',
                'data' => ''
            ]);
        } catch (\Exception $e) {

            return $response=([
                'status' => 'failure',
                'message' => "",
                'data' => $e->getmessage() . ' Line'.$e->getline()
            ]);
        }
    }
}
