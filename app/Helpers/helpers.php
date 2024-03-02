<?php

use App\Models\VmtEmployeeLeaveBalance;
use App\Models\VmtMasterConfig;
use App\Models\VmtOrgRoles;
use App\Models\User;
use App\Models\VmtClientMaster;
use App\Models\VmtEmployee;
use App\Models\VmtBloodGroup;
use App\Models\VmtLeaves;
use App\Models\ConfigPms;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtEmpAssignSalaryAdvSettings;
use App\Models\Department;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

function required()
{
    $required = "<span class='text-danger required_star'>*</span>";
    return $required;
}

function dropColumnIfExists($table_name, $column_name)
{
    if (Schema::hasColumn($table_name, $column_name)) //check the column
    {
        Schema::table($table_name, function (Blueprint $table) use ($column_name) {
            $table->dropColumn($column_name); //drop it
        });
    }
}

function fetchMasterConfigValue($config_name)
{
    return VmtMasterConfig::where('config_name', '=', $config_name)->get()->value('config_value');
}

function getEmployeeClientDetails($emp_id)
{
    $emp_client_id = User::find($emp_id)->client_id;
    //$client_code = preg_replace('/\d/', '', $emp_code);

    $query_client_details = VmtClientMaster::where('id', '=', $emp_client_id);

    if ($query_client_details->exists())
        return $query_client_details->first()->id;
    else
        return null;
}

function getClientList()
{
    return VmtClientMaster::all();
}

function getBloodGroupName($blood_group_id)
{
    if (!empty($blood_group_id))
        return VmtBloodGroup::find($blood_group_id)->name;
    else
        return null;
}

function getEmployeeActiveStatus($user_id)
{

    if (!empty($user_id)) {
        $active_status = User::find($user_id)->active;

        if ($active_status == "1")
            return "Active";
        else
            if ($active_status == "0")
                return "Yet to Activate";
            else
                if ($active_status == "-1")
                    return "Left";
                else
                    return null;
    } else
        return null;
}


function sessionGetSelectedClientCode()
{
    $query_client = VmtClientMaster::find(session('client_id'));

    if (!empty($query_client))
        return $query_client->client_code;
    else
        return "";
}
function sessionGetSelectedClientid()
{
    $query_client = VmtClientMaster::find(session('client_id'));

    if (!empty($query_client))
        return $query_client->id;
    else
        return "";
}

function sessionGetSelectedClientName()
{

    $query_client = VmtClientMaster::find(session('client_id'));

    if (!empty($query_client))
        return $query_client->client_name;
    else
        return "";
}




function sessionGetSelected_abs_clientcode()
{

    $query_client = VmtClientMaster::find(session('client_id'));

    if (!empty($query_client))
        return $query_client->abs_client_code;
    else
        return "";
}
function GetSelectedClientFullName($client_id)
{

    $query_client = VmtClientMaster::where('id', $client_id)->first();

    if (!empty($query_client))
        return $query_client->client_fullname;
    else
        return "";
}

function GetSelected_abs_clientcode($client_id)
{

    $query_client = VmtClientMaster::where('id', $client_id)->first();

    if (!empty($query_client))
        return $query_client->abs_client_code;
    else
        return "";
}

function getClientName($user_id)
{
    $query_client = VmtClientMaster::find(User::find($user_id)->client_id);

    if (!empty($query_client))
        return $query_client->client_name;
    else
        return "";
}

function getClientFullName($user_id)
{
    $query_client = VmtClientMaster::find(User::find($user_id)->client_id);

    if (!empty($query_client))
        return $query_client->client_fullname;
    else
        return "";
}

function getClientLogo($user_id)
{
    $query_client = VmtClientMaster::find(User::find($user_id)->client_id);

    if (!empty($query_client))
        return $query_client->client_logo;
    else
        return "";
}

function getSessionCurrentlySelectedClientEmp($user_id)
{
    $query_client = VmtClientMaster::find(User::find($user_id)->client_id);

    if (!empty($query_client))
        return $query_client;
    else
        return "";
}

function sessionGetSelectedClientLogo()
{

    $query_client = VmtClientMaster::find(session('client_id'));
    if (!empty($query_client))
        return $query_client->client_logo;
    else
        return "";
}

function getSessionCurrentlySelectedClient()
{

    $query_client = VmtClientMaster::find(session('client_id'));
    if (!empty($query_client))
        return $query_client;
    else
        return "";
}
function getOrganization_HR_Details()
{
    $master_config_value = VmtMasterConfig::where('config_name', 'hr_userid')->first();

    if (empty($master_config_value)) {
        // dd("HR not set");
        return null;
    } else {
        $master_config_value = $master_config_value->config_value;

        $hr_details = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
            ->where('users.id', $master_config_value)->first(['users.name', 'vmt_employee_office_details.officical_mail']);
    }
    // dd($hr_details);

    return $hr_details;
}

function fetchPMSConfigValue($config_name)
{
    return ConfigPms::first()->value($config_name);
}

function isEmailExists($email)
{
    if (User::where('email', $email)->exists())
        return "true";
    else
        return "false";
}

function isEmpCodeExists($emp_code)
{
    if (User::where('user_code', $emp_code)->exists())
        return "true";
    else
        return "false";
}


function updateUserRole($user_code, $role_name)
{
    $role = VmtOrgRoles::where('name', $role_name)->first('id');
    //dd($role_id);
    $user = User::where('user_code', $user_code)->first();
    $user->org_role = $role->id;
    $user->save();
}

function currentLoggedInUserRole()
{
    return $role = VmtOrgRoles::where('id', auth()->user()->org_role)->value('name');
}

function getUserRole($org_role_id)
{
    return $role = VmtOrgRoles::where('id', $org_role_id)->value('name');
}

function getTeamMembersUserIds($user_id)
{
    $user_code = User::find($user_id)->user_code;

    $user_ids = VmtEmployeeOfficeDetails::where('l1_manager_code', $user_code)->pluck('user_id');

    //dd($user_ids);
    return $user_ids;
}

/*
    !!!! TODO :  Need to remove this function
*/
function getCurrentClientName()
{
    $client_name = VmtClientMaster::all()->value('client_name');
    //dd($client_name);
    return $client_name;
}

function hasSubClients()
{
    $sub_clients_count = VmtClientMaster::all()->count();
    if ($sub_clients_count > 1)
        return true;
    else
        return false;
}


function fetchClients()
{
    return VmtClientMaster::all(['id', 'client_name', 'client_logo']);
}

/*
        Check whether all the documents for the given
        employee code is approved or not

    */
function isAllDocumentsApproved($user_id)
{
    $json_documents_filenames = json_decode(VmtEmployee::where('userid', $user_id)->value('docs_reviewed'));

    if (!empty($json_documents_filenames)) {

        //check whether each document value is '1'
        foreach ($json_documents_filenames as $key => $value) {
            //-1 = Not yet approved
            //0 = Rejected
            if ($key == "aadhar_card_file" || $key == "pan_card_file" || $key == "aadhar_card_backend_file") {
                if ($value == -1 || $value == 0) {
                    return false;
                }
            }
        }

        return true;
    } else {
        // dd($documents_filenames);

        return false;
    }
}

function getAllBloodGroupNames()
{
    return VmtBloodGroup::all(['id', 'name']);
}


function getUserShortName($user_id)
{
    //  dd(User::find($user_id));

    $username = User::find($user_id)->name;
    $username = trim($username);

    $dotPattern = preg_split('/\.+/', $username);
    $whiteSpacePattern = preg_split('/\s+/', $username);
    $singleWordPattern = str_split($username);

    if (count($dotPattern) > 1) {
        $toStore = trim($dotPattern[0])[0] . trim($dotPattern[1])[0];
        return strtoupper($toStore);
    } else
        if (count($whiteSpacePattern) > 1) {
            $toStore = $whiteSpacePattern[0][0] . $whiteSpacePattern[1][0];
            return strtoupper($toStore);
        } else {
            $toStore = $singleWordPattern[0] . $singleWordPattern[1];
            return strtoupper($toStore);
        }

    // return $whiteSpacePattern;
}

function shortNameBGColor($shortName)
{

    $colorPalette = "";
    $getAsciiCodeFirstChar = ord(strtoupper($shortName[0]));
    $getAsciiCodeSecondChar = ord(strtoupper($shortName[1]));
    if (($getAsciiCodeFirstChar >= 65 && $getAsciiCodeFirstChar < 68) && ($getAsciiCodeSecondChar >= 65 && $getAsciiCodeSecondChar < 68)) {
        $colorPalette = "color_wildBlueYonder";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 65 && $getAsciiCodeFirstChar < 68) && ($getAsciiCodeSecondChar >= 68 && $getAsciiCodeSecondChar < 72)) {
        $colorPalette = "color_disco-400";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 65 && $getAsciiCodeFirstChar < 68) && ($getAsciiCodeSecondChar >= 72 && $getAsciiCodeSecondChar < 76)) {
        $colorPalette = "color_cinnabar";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 65 && $getAsciiCodeFirstChar < 68) && ($getAsciiCodeSecondChar >= 76 && $getAsciiCodeSecondChar < 85)) {
        $colorPalette = "color-green-400";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 65 && $getAsciiCodeFirstChar < 68) && ($getAsciiCodeSecondChar >= 85 && $getAsciiCodeSecondChar <= 89)) {
        $colorPalette = "color_navyBlue";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 68 && $getAsciiCodeFirstChar < 72) && ($getAsciiCodeSecondChar >= 65 && $getAsciiCodeSecondChar < 68)) {
        $colorPalette = "color-pink-200";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 68 && $getAsciiCodeFirstChar < 72) && ($getAsciiCodeSecondChar >= 65 && $getAsciiCodeSecondChar < 75)) {
        $colorPalette = "color-pink-600";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 72 && $getAsciiCodeFirstChar < 78) && ($getAsciiCodeSecondChar >= 65 && $getAsciiCodeSecondChar < 72)) {
        $colorPalette = "color-pink-400 ";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 72 && $getAsciiCodeFirstChar < 78) && ($getAsciiCodeSecondChar >= 72 && $getAsciiCodeSecondChar < 80)) {
        $colorPalette = "lighthWisteria";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 78 && $getAsciiCodeFirstChar < 75) && ($getAsciiCodeSecondChar >= 75 && $getAsciiCodeSecondChar < 85)) {
        $colorPalette = "color-sandal-600";
        return $colorPalette;
    } else if ($getAsciiCodeFirstChar >= 70 && $getAsciiCodeFirstChar < 80) {
        $colorPalette = "color_disco-600";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 80 && $getAsciiCodeFirstChar < 85) && ($getAsciiCodeSecondChar >= 65 && $getAsciiCodeSecondChar < 75)) {
        $colorPalette = "color-gradient-green";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 80 && $getAsciiCodeFirstChar < 85) && ($getAsciiCodeSecondChar >= 75 && $getAsciiCodeSecondChar < 82)) {
        $colorPalette = "color-gradient-orange";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 85 && $getAsciiCodeFirstChar < 89) && ($getAsciiCodeSecondChar >= 75 && $getAsciiCodeSecondChar < 80)) {
        $colorPalette = "color-gradient-pink";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 80 && $getAsciiCodeFirstChar < 85) && ($getAsciiCodeSecondChar >= 80 && $getAsciiCodeSecondChar < 85)) {
        $colorPalette = " color-gradient-green-200";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 85 && $getAsciiCodeFirstChar < 89) && ($getAsciiCodeSecondChar >= 65 && $getAsciiCodeSecondChar < 75)) {
        $colorPalette = "color-blue-600";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 85 && $getAsciiCodeFirstChar <= 90) && ($getAsciiCodeSecondChar >= 65 && $getAsciiCodeSecondChar < 70)) {
        $colorPalette = "color_disco-500";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 85 && $getAsciiCodeFirstChar <= 90) && ($getAsciiCodeSecondChar >= 70 && $getAsciiCodeSecondChar < 75)) {
        $colorPalette = "color-skyblue-500";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 85 && $getAsciiCodeFirstChar <= 90) && ($getAsciiCodeSecondChar >= 75 && $getAsciiCodeSecondChar < 80)) {
        $colorPalette = "color-inkblue-600";
        return $colorPalette;
    } else if (($getAsciiCodeFirstChar >= 85 && $getAsciiCodeFirstChar <= 90) && ($getAsciiCodeSecondChar >= 80 && $getAsciiCodeSecondChar <= 90)) {
        $colorPalette = "color-blue-200";
        return $colorPalette;
    } else {
        $colorPalette = "downy";
        return $colorPalette;
    }
}


function getEmployeeAvatarOrShortName($user_id)
{

    try {
        // dd($user_id);
        $user = User::where('id', $user_id);
        $avatar = $user->value('avatar');
        $responseJSON = null;

        //IF images doesnt exists, then generate ShortName
        if (empty($avatar) || !file_exists(public_path('images/' . $avatar))) {
            //send the shortname
            $responseJSON['type'] = 'shortname';
            $responseJSON['data'] = strtoupper(getUserShortName($user_id));
        } else {
            //send the profile pic
            $responseJSON['type'] = 'avatar';
            $responseJSON['data'] = $avatar;
        }

        //Add color

        $responseJSON['color'] = shortNameBGColor($responseJSON['data']);

        return json_encode($responseJSON);
    } catch (Throwable $e) {
        dd("ERROR : helper.php :: getEmployeeAvatarOrShortName() for user_id : " . $e);
    }
}

function getCurrentUserGender()
{

    $currentuserid = auth()->user()->id;
    $emp_gender = VmtEmployee::where('userid', $currentuserid)->first();

    if (!empty($emp_gender)) {

        $lowerCaseGender = strtolower($emp_gender->gender);

        if ($lowerCaseGender == 'male') {
            return "male";
        } else
            if ($lowerCaseGender == 'female') {
                return "female";
            } else {
                return "invalid gender";
            }
    } else {
        return "invalid gender";
    }
}

function newgetEmployeeAvatarOrShortName($user_id)
{

    try {
        // dd($user_id);
        $user = User::where('id', $user_id);
        $avatar = $user->value('avatar');
        $user_code = $user->value('user_code');
        $responseJSON = null;

        $get_emp_profile = Storage::disk('private')->get($user_code . "/profile_pics/" . $avatar);

        //IF images doesnt exists, then generate ShortName
        if (empty($avatar) || empty($get_emp_profile)) {
            //send the shortname
            $responseJSON['type'] = 'shortname';
            $responseJSON['data'] = strtoupper(getUserShortName($user_id));
            $responseJSON['color'] = shortNameBGColor($responseJSON['data']);
        } else {
            //send the profile pic
            $responseJSON['type'] = 'avatar';

            // $get_emp_profile  = Storage::disk('private')->get($user_code."/profile_pics/".$avatar);

            $get_emp_profile = storage_path("employees/" . $user_code . "/profile_pics/" . $avatar);

            $responseJSON['data'] = base64_encode(file_get_contents($get_emp_profile));
        }

        //Add color



        return json_encode($responseJSON);
    } catch (Throwable $e) {
        dd("ERROR : helper.php :: getEmployeeAvatarOrShortName() for user_id : " . $e);
    }
}


function isAppointmentLetterTemplateAvailable()
{

    $client_name = Str::lower(str_replace(' ', '', sessionGetSelectedClientName()));

    //$client_name = Str::lower(str_replace(' ', '', getCurrentClientName()) );
    $viewfile_appointmentletter = 'mailtemplate_appointmentletter_' . $client_name;
    //dd($viewfile_appointmentletter);
    //dd('vmt_appointment_templates.'.$viewfile_appointmentletter);
    //Throw error if appointment letter missing for this client
    if (view()->exists('vmt_appointment_templates.' . $viewfile_appointmentletter)) {
        return true;
    } else {
        return false;
    }
}

function calculateProfileCompleteness($user_id)
{

    $user_full_details = User::leftjoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
        ->leftjoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
        ->leftjoin('vmt_employee_family_details', 'vmt_employee_family_details.user_id', '=', 'users.id')
        ->leftjoin('vmt_employee_emergency_contact_details', 'vmt_employee_emergency_contact_details.user_id', '=', 'users.id')
        ->leftjoin('vmt_marital_status', 'vmt_marital_status.id', '=', 'vmt_employee_details.marital_status_id')

        //Employee info

        ->select(
            'vmt_employee_details.mobile_number',
            'users.email',
            'vmt_employee_details.dob',
            'vmt_employee_details.present_address',
            'vmt_employee_details.gender',
            'vmt_employee_office_details.l1_manager_code',

            //Personal Info
            'vmt_employee_details.passport_number',
            'vmt_employee_details.passport_date',
            'vmt_employee_details.nationality',
            'vmt_employee_details.religion',
            'vmt_marital_status.name',
            //'vmt_employee_details.spouse_name',

            //Documents
            'vmt_employee_details.aadhar_card_file',
            'vmt_employee_details.aadhar_card_backend_file',
            'vmt_employee_details.pan_card_file',
            'vmt_employee_details.passport_file',
            'vmt_employee_details.voters_id_file',
            'vmt_employee_details.dl_file',
            'vmt_employee_details.education_certificate_file',
            'vmt_employee_details.reliving_letter_file',

            //'vmt_employee_details.no_of_children',


            //Family Informations
            'vmt_employee_family_details.name',
            'vmt_employee_family_details.relationship',
            'vmt_employee_family_details.dob',
            'vmt_employee_family_details.phone_number',

            //Bank Informations
            'vmt_employee_details.bank_id',
            'vmt_employee_details.bank_ifsc_code',
            'vmt_employee_details.bank_account_number',

            //Emergency Contact
            'vmt_employee_emergency_contact_details.name',
            'vmt_employee_emergency_contact_details.relationship',
            'vmt_employee_emergency_contact_details.phone_number_1',
            'vmt_employee_emergency_contact_details.phone_number_2'

        )->where('users.id', $user_id)->first();

    $count_total_fields = count($user_full_details->toArray());
    $count_null_fields = 0;

    foreach ($user_full_details->toArray() as $key => $value) {
        if (empty($value)) {
            //dd($key);
            $count_null_fields++;
        }
    }

    //dd($count_total_fields);
    //dd($count_null_fields);
    //dd($user_full_details);

    $value = (int) (round((($count_total_fields - $count_null_fields) / $count_total_fields) * 100));
    //dd($value);
    return $value;
}

function num2alpha($n)
{
    $r = '';
    for ($i = 1; $n >= 0 && $i < 10; $i++) {
        $r = chr(0x41 + ($n % pow(26, $i) / pow(26, $i - 1))) . $r;
        $n -= pow(26, $i);
    }
    return $r;

}

function getGenderNeutralTerm($user_id)
{

    $emp_details = VmtEmployee::where('userid', $user_id)->first();

    if (isset($emp_details->gender)) {

        $emp_details = strtoupper($emp_details->gender);

        if (empty($emp_details)) {
            $result = "Mr / Ms.";
        } else if ($emp_details == "FEMALE") {
            $result = "Ms.";
        } else if ($emp_details == "MALE") {
            $result = "Mr.";
        }
    } else {
        $result = "Mr. / Ms.";
    }

    return $result;

}

function numberToWord($num)
{
    $number = $num;
    $number1 = $number;
    $no = floor($number);
    $hundred = null;
    $digits_1 = strlen($no); //to find lenght of the number
    $i = 0;
    // Numbers can stored in array format
    $str = array();

    $words = array(
        '0' => '',
        '1' => 'One',
        '2' => 'Two',
        '3' => 'Three',
        '4' => 'Four',
        '5' => 'Five',
        '6' => 'Six',
        '7' => 'Seven',
        '8' => 'Eight',
        '9' => 'Nine',
        '10' => 'Ten',
        '11' => 'Eleven',
        '12' => 'Twelve',
        '13' => 'Thirteen',
        '14' => 'Fourteen',
        '15' => 'Fifteen',
        '16' => 'Sixteen',
        '17' => 'Seventeen',
        '18' => 'Eighteen',
        '19' => 'Nineteen',
        '20' => 'Twenty',
        '30' => 'Thirty',
        '40' => 'Forty',
        '50' => 'Fifty',
        '60' => 'Sixty',
        '70' => 'Seventy',
        '80' => 'Eighty',
        '90' => 'Ninety'
    );

    $digits = array('', 'Hundred', 'Thousand', 'lakh', 'Crore');
    //Extract last digit of number and print corresponding number in words till num becomes 0
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        //Round numbers down to the nearest integer
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;

        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] . " " .
                $digits[$counter] .
                $plural . " " .
                $hundred : $words[floor($number / 10) * 10] . " " .
                $words[$number % 10] . " " .
                $digits[$counter] . $plural . " " .
                $hundred;
        } else
            $str[] = null;
    }

    $str = array_reverse($str);
    $result = implode('', $str); //Join array elements with a string

    return 'Rupees ' . $result . ' Only';

}
function getAllDropdownFilterSetting()
{

    $current_client_id = auth()->user()->client_id;


    try {

        $queryGetDept = Department::select('id', 'name')->get();

        $queryGetDesignation = VmtEmployeeOfficeDetails::select('designation')->where('designation', '<>', 'S2 Admin')->whereNotNull("designation")->distinct()->get();

        $queryGetLocation = VmtEmployeeOfficeDetails::select('work_location')->whereNotNull("work_location")->distinct()->get();

        $queryGetstate = State::select('id', 'state_name')->distinct()->get();

        if ($current_client_id == 1) {

            $queryGetlegalentity = VmtClientMaster::select('id', 'client_name')->distinct()->get();

        } elseif ($current_client_id == 0) {

            $queryGetlegalentity = VmtClientMaster::select('id', 'client_name')->distinct()->get();
        } elseif ($current_client_id == 2) {

            $queryGetlegalentity = VmtClientMaster::where('id', $current_client_id)->distinct()->get(['id', 'client_name']);
        } elseif ($current_client_id == 3) {

            $queryGetlegalentity = VmtClientMaster::where('id', $current_client_id)->distinct()->get(['id', 'client_name']);
        } elseif ($current_client_id == 4) {

            $queryGetlegalentity = VmtClientMaster::where('id', $current_client_id)->distinct()->get(['id', 'client_name']);
        }


        $getsalary = ["department" => $queryGetDept, "designation" => $queryGetDesignation, "location" => $queryGetLocation, "state" => $queryGetstate, "legalEntity" => $queryGetlegalentity];


        return response()->json($getsalary);
    } catch (\Exception $e) {
        return response()->json([
            "status" => "failure",
            "message" => "Error fetching the dropdown value",
            "data" => $e,
        ]);
    }
}

function numberFormat($number, $decimals = 0)
{
    if (strpos($number, '.') != null) {
        $decimalNumbers = substr($number, strpos($number, '.'));
        $decimalNumbers = substr($decimalNumbers, 1, $decimals);
    } else {
        $decimalNumbers = 0;
        for ($i = 2; $i <= $decimals; $i++) {
            $decimalNumbers = $decimalNumbers . '0';
        }
    }


    $number = (int) $number;
    $number = strrev($number);  // reverse

    $n = '';
    $stringlength = strlen($number);

    for ($i = 0; $i < $stringlength; $i++) {
        // from digit 3, every 2 digit () add comma
        if ($i == 2 || ($i > 2 && $i % 2 == 0))
            $n = $n . $number[$i] . ',';
        else
            $n = $n . $number[$i];
    }

    $number = $n;
    $number = strrev($number); // reverse

    ($decimals != 0) ? $number = $number . '.' . $decimalNumbers : $number;
    if ($number[0] == ',')
        $number = substr_replace($number, '', 0, 1);
    if ($number[1] == ',' && $number[0] == '-')
        $number = substr_replace($number, '', 1, 1);

    return '₹' . $number;
}
function days_in_month($month, $year)
{
    // calculate number of days in a month
    return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
}


