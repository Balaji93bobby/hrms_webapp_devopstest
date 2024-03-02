<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;
use App\Models\AbsSalaryProjection;
use App\Models\VmtEmployeeDocuments;
use App\Models\VmtInvEmpFormdata;
use App\Models\vmtInvEmp_Fsp_Popups;
use App\Models\VmtInvForm;
use App\Models\VmtPayroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\VmtEmployeePaySlip;
use App\Models\Compensatory;
use App\Imports\VmtPaySlip;
use Dompdf\Options;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use PDF;
use DateTime;
use App\Models\VmtEmployeeInvestmentsDeclarationAmount;
use App\Models\VmtEmployeeInvestmentsDeclarationFields;
use App\Models\VmtInvestmentForm;
use App\Models\AbsActivePayslip;
use App\Models\VmtOrgTimePeriod;
use App\Models\VmtInvestmentParticulars;
use App\Models\VmtEmployeePayroll;
use App\Models\VmtInvestmentSections;
use App\Models\VmtInvestmentSection_Particulars;
use App\Models\VmtInvestmentForm_SectionParticulars;
use App\Models\VmtInvestmentDeclarationsFields;
use App\Models\User;
use App\Models\VmtEmployee;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtEmployeeStatutoryDetails;
use App\Models\VmtClientMaster;
use Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttenanceWorkShifttime;
use App\Imports\VmtInvSectionImport;
use App\Models\VmtInvFEmpAssigned;
use App\Models\VmtInvFormSection;

use Carbon\Carbon;
use App\Http\Controllers\VmtEmployeeBirthdayController;
use Carbon\CarbonPeriod;
use App\Models\VmtEmployeePaySlipV2;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;
use App\Services\VmtEmployeeService;
use App\Services\VmtAttendanceService;
use App\Mail\WelcomeMail;
use App\Models\VmtDocuments;
use App\Jobs\sendemailjobs;
use Illuminate\Support\Facades\Validator;


class VmtTestingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /*
    Download private file.
    */
    public function downloadPrivateFile()
    {
        $private_file = "employee/emp_B090/documents/voterIdB090_22-03-2023 15-47-22.jpg";

        //dd(Storage::disk('private')->allFiles());
        return Storage::disk('private')->download($private_file);
    }

    /*
    View private file such as image
    */
    public function viewPrivateFile()
    {
        //$private_file = "B090/onboarding_documents/AadharCardBack_B090_13-04-2023_18-23-34.jpg";
        $private_file = "/PLIPL068/onboarding_documents/voterIdB090_22-03-2023 15-47-22.jpg";
        //dd(file(storage_path('employees/'.$private_file)));
        return response()->file(storage_path('employees/' . $private_file));
    }


    public function viewBASE64_PrivateFile()
    {
        //dd("asda");

        //$private_file = "B090/onboarding_documents/AadharCardBack_B090_13-04-2023_18-23-34.jpg";
        $private_file = "PLIPL068/profile_pics/mk.jpg";
        //dd(file(storage_path('employees/'.$private_file)));
        $output = File::get(storage_path('employees/' . $private_file));

        return base64_encode($output);
    }

    public function testingpdf()
    {
        $client_name = 'brandavatar';
        $viewfile_appointmentletter = 'vmt_appointment_templates.mailtemplate_appointmentletter_' . $client_name;
        $html = view($viewfile_appointmentletter);

        $pdf = new Dompdf();
        $pdf->loadHtml($html, 'UTF-8');
        //    dd($pdf);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        return $pdf->stream($client_name . '.pdf');
    }
    public function fileUploadingTest(Request $request)
    {
        dd($request->all());
        $emp_code = 'SA300';
        $date = date('d-m-Y H-i-s');
        $fileName = 'aadhar_' . $emp_code . '_' . $date . '.' . $request->file->extension();
        $path = 'employee/emp_';

        $fileName = time() . '_' . $request->file->getClientOriginalName();
        $emp_document_path = Storage::disk('private');

        dd(File::makeDirectory('storage/app/uploads/Emp_code', 0777, true, true));
        if (!$emp_document_path->exists('Emp_code')) {
            File::makeDirectory('storage/app/uploads/Emp_code', 0777, true, true);
        }
        $filePath = $request->file->storeAs('Emp_code', $fileName, 'private');
        $fileModel->name = time() . '_' . $request->file->getClientOriginalName();
        $fileModel->file_path = '/storage/' . $filePath;
        $fileModel->save();
        return back()
            ->with('success', 'File has been uploaded.')
            ->with('file', $fileName);
    }

    public function viewpdf()
    {
        $pathToFile = storage_path('uploads\employee\emp_B090\documents/' . "voterIdB090_21-03-2023 12-32-42.png");
        //$pathToFile = public_path('images/'.'avatar_SA100_2023-01-18_05_57_46pm.JPG');

        // if(!File::exists($pathToFile)){
        //     abort(404);
        // }else{
        //     $file = File::get( $pathToFile);
        //     $type = File::mimeType($pathToFile);
        //     $response = Response::make($file, 200);
        //     $response->header("Content-Type", $type);
        // }

        $base64 = base64_encode($pathToFile);
        $image_data = 'data:' . mime_content_type($pathToFile) . ';base64,' . $base64;
        // dd( $image_data);
        return view('testing', compact('pathToFile', 'image_data', 'base64'));
    }


    public function retriveFiles(Request $request)
    {
        $pathToFile = storage_path('uploads\employee\emp_B090\documents/' . "voterIdB090_21-03-2023 12-32-42.png");
        //     dd( $pathToFile);
        //     dd(Storage::disk('local')->getAdapter()->applyPathPrefix('\employee\emp_B090\documents'));
        //     dd(Storage::disk('private')->path(''));
        //     dd(Storage::disk('private')->getAdapter()->setprefixer());
        //     dd(Storage::disk('private')->get('voterIdB090_21-03-2023 12-32-42.png'));
        //      //dd(Storage::disk('private')->directories('employee/emp_B090') );
        //    dd(Storage::disk('D:\Laravelworks\lara_abs_pms\storage\uploads\employee\emp_B090\documents')->exists('voterIdB090_21-03-2023 12-32-42.png'));
        //  dd((Storage::get($pathToFile)));
        return $pathToFile;
    }

    /*
    Send appointment letter as PDF attachement in email
    */
    public function mailTest_sendAppointmentLetter(Request $request, VmtEmployeeService $employeeService)
    {

        $to_email = $request->email;
        $employeeData = array();

        //Add dummy data
        $employeeData['employee_name'] = "TestUser";
        $employeeData['employee_code'] = "ABS001";
        $employeeData['email'] = "karthigaiselvan28072000@gmail.com";

        $employeeData['basic'] = 10000;
        $employeeData['hra'] = 10000;
        $employeeData['special_allowance'] = 10000;
        $employeeData["basic"] = 10000;
        $employeeData["statutory_bonus"] = 10000;
        $employeeData["child_education_allowance"] = 10000;
        $employeeData["food_coupon"] = 10000;
        $employeeData["lta"] = 10000;
        $employeeData["special_allowance"] = 10000;
        $employeeData["other_allowance"] = 10000;
        $employeeData['epf_employer_contribution'] = 10000;
        $employeeData['esic_employer_contribution'] = 10000;
        $employeeData['gross_monthly'] = 10000;
        $employeeData["epf_employer_contribution"] = 10000;
        $employeeData["professional_tax"] = 10000;
        $employeeData["net_income"] = 10000;

        $response = $employeeService->attachAppointmentLetterPDF($employeeData);

        return $response;
    }

    public function investmenttesting()
    {
        $investment_formname = "invertment form 1";

        //Get investment form
        //$form_id = VmtInvestmentForm::where('form_name',$investment_formname)->first()->id;

        $inv_form_details = VmtInvestmentForm::join('vmt_investment_form_secpat', 'vmt_investment_form_secpat.form_id', '=', 'vmt_investment_forms.id')
            ->join('vmt_investment_section_particulars', 'vmt_investment_section_particulars.id', '=', 'vmt_investment_form_secpat.sec_pat_id') //Get sections_particulars id
            ->join('vmt_investment_sections', 'vmt_investment_sections.id', '=', 'vmt_investment_section_particulars.section_id') // Get Sections
            ->join('vmt_investment_particulars', 'vmt_investment_particulars.id', '=', 'vmt_investment_section_particulars.particular_id') // Get Particular id
            ->join('vmt_inv_fsp_popups', 'vmt_inv_fsp_popups.fsp_id', '=', 'vmt_investment_form_secpat.id')
            ->join('vmt_inv_emp_fsp_popups', 'vmt_inv_emp_fsp_popups.fsp_popups_id', '=', 'vmt_inv_fsp_popups.id')
            ->join('vmt_inv_popup_fields', 'vmt_inv_popup_fields.id', '=', 'vmt_inv_fsp_popups.popupfield_id')
            ->join('vmt_inv_popup_list', 'vmt_inv_popup_list.id', '=', 'vmt_inv_popup_fields.popups_list_id')
            ->join('vmt_emp_investments_dec_amt', 'vmt_emp_investments_dec_amt.form_sectionparticular_id', '=', 'vmt_investment_form_secpat.id')



            // ->where('vmt_investment_forms.form_name',$investment_formname)
            ->get([
                'vmt_investment_sections.section_name as section_name',
                'vmt_investment_particulars.particular_name as particular_name',
                'vmt_investment_particulars.references as references',
                'vmt_investment_particulars.amount_max_limit as amount_max_limit',
                'vmt_inv_popup_list.popups_list as popup_name',
                'vmt_inv_popup_fields.field_name as field_name',
                'vmt_inv_emp_fsp_popups.popup_value as popup_value',
                'vmt_inv_emp_fsp_popups.user_id as User_id',
                'vmt_emp_investments_dec_amt.declaration_amount as Declaration_amount',

            ]);
        // dd($inv_form_details);

        return($inv_form_details->toArray());
        //   dd($inv_form_details->toArray());


        // $siimm2 = VmtInvestmentForm_SectionParticulars::join('vmt_emp_investments_dec_fields', 'vmt_investment_form_secpat.id', '=', 'vmt_emp_investments_dec_fields.form_sectionparticular_id')
        //     ->join('vmt_emp_investments_dec_amt', 'vmt_investment_form_secpat.id', '=', 'vmt_emp_investments_dec_amt.form_sectionparticular_id')
        //     ->first();

        // dd([$invesform, $invesdec, $invessec_pat, $investsec, $investparticular]);
    }

    public function testSendBulkMail()
    {

        // $array_mail = ["sheltonfdo23@gmail.com"];

        // $client_id=User::where('user_code',$user_code)->first();

        // $VmtClientMaster = VmtClientMaster::where('id',$client_id->client_id)->first();

        $VmtClientMaster = VmtClientMaster::where('id', $client_id->client_id)->first();

        $image_view = url('/') . $VmtClientMaster->client_logo;

        //     foreach ($array_mail as $recipient) {
        $isSent = \Mail::to('sheltonfdo23@gmail.com')->send(new WelcomeMail());

        return $isSent ? "Success" : "failure";

        // $temp[$recipient] = $isSent;

        //             array_push($response, $temp);
        //         }

        //         return response()->json([
        //             "output" => $response
        //         ]);
        //     } catch (\Exception $e) {
        //         dd("Error : " . $e);
        //     }
    }

    public function sendHTMLEmail(Request $request)
    {

        try {

            $validator = Validator::make(
                $request->all(),
                $rules = [
                    "email" => 'required',
                ],
                $messages = [
                    "required" => "Field :attribute is missing",
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->all()
                ]);
            }

            $isSent = \Mail::to($request->email)->send(new TestEmail($request->email));

            return "success";
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "",
                "data" => $e->getMessage(),
            ]);
        }
    }

    public function exportattenance(Request $request)
    {
        $users = User::all()->toArray();

        //  return $users;
        // dd($users);
        // dd(gettype($users));

        return Excel::download(new AttenanceWorkShifttime($users), 'testings.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function downloadPaySlip_pdfView(Request $request)
    {

        if (empty($request->uid)) {
            if (empty($request->user_code)) {
                $user_code = auth()->user()->user_code;
            } else
                $user_code = $request->user_code;
        } else {
            $user_code = User::find(Crypt::decryptString($request->uid))->user_code;
            //dd("Enc User details from request : ".$user);
        }
        $user_id = User::where('user_code', $user_code)->first()->id;
        $month = $request->month;
        $year = $request->year;
        $user = null;

        //If empty, then show current user profile page
        if (empty($user_id)) {
            $user = auth()->user();
        } else {
            $user = User::find($user_id);
        }

        $payroll_month = VmtPayroll::whereMonth('payroll_date', $month)
            ->whereYear('payroll_date', $year)->where('client_id', $query_user->client_id)->first();
        //dd(payroll_month);

        $emp_payslip_id = VmtEmployeePayroll::where('user_id', $user_id)->where('payroll_id', $payroll_month->id)->first()->id;

        $data['employee_payslip'] = VmtEmployeePaySlipV2::where('emp_payroll_id', $emp_payslip_id)->first();

        $data['emp_payroll_month'] = $payroll_month;

        $data['employee_name'] = $user->name;
        // dd( $data['employee_name']);
        $data['employee_office_details'] = VmtEmployeeOfficeDetails::where('user_id', $user->id)->first();
        $data['employee_details'] = VmtEmployee::where('userid', $user->id)->first();
        $data['employee_statutory_details'] = VmtEmployeeStatutoryDetails::where('user_id', $user->id)->first();

        $query_client = VmtClientMaster::find($user->client_id);

        $data['client_logo'] = $query_client->client_logo;
        $client_name = $query_client->client_name;

        $processed_clientName = strtolower(str_replace(' ', '', $client_name));

        //dd($client_name);
        //$html =  view('vmt_payslipTemplate', $data);
        //dd($data['employee_statutory_details']->uan_number)


        // $pdf = PDF::loadView('vmt_payslip_templates.template_payslip_brandavatar', $data);

        $html = view('vmt_payslip_templates.template_payslip_' . $processed_clientName, $data);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $pdf = new Dompdf($options);
        $pdf->loadhtml($html, 'UTF-8');
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        //$response=base64_encode($pdf->stream([$client_name.'.pdf']));
        $response = base64_encode($pdf->output([$client_name . '.pdf']));
        ;

        return response()->json([
            'status' => 'success',
            'message' => "",
            'data' => $response
        ]);

        // Mail::send('vmt_payslip_templates.template_payslip_brandavatar', $data, function ($message) use ($data, $pdf) {

        //     $message->to('sathishrain2001@gmail', 'sathishrain2001@gmail.com')

        //         ->subject($data['employee_name'])

        //         ->attachData($pdf->output(), "text.pdf");

        // });

        //  dd('Mail sent successfully');
    }

    public function numberToWord($num)
    {
        $num = (string) ((int) $num);
        if ((int) ($num) && ctype_digit($num)) {
            $words = array();
            $num = str_replace(array(',', ' '), '', trim($num));

            // dd($request->all());

            //   $simma = new vmtInvEmp_Fsp_Popups;
            //   $simma->user_id = ('141');
            //   $simma->fsp_popups_id = ('2');
            //   $simma->popup_value = $request->input('from_month');
            //   $simma->popup_value = $request->input('to_month');
            //   $simma->save();

            $createMultipleUsers = [
                ['user_id' => '141', 'fsp_popups_id' => '1', 'popup_value' => $request->input('from_month')],
                ['user_id' => '141', 'fsp_popups_id' => '2', 'popup_value' => $request->input('to_month')],
                ['user_id' => '141', 'fsp_popups_id' => '5', 'popup_value' => $request->input('city')],
                ['user_id' => '141', 'fsp_popups_id' => '6', 'popup_value' => $request->input('totalRent')],
                ['user_id' => '141', 'fsp_popups_id' => '7', 'popup_value' => $request->input('land_lard')],
                ['user_id' => '141', 'fsp_popups_id' => '8', 'popup_value' => $request->input('landpan')],
                ['user_id' => '141', 'fsp_popups_id' => '9', 'popup_value' => $request->input('address')],

            ];

            vmtInvEmp_Fsp_Popups::insert($createMultipleUsers);





            return 'save successfully';
        }
    }


    public function importexcell(Request $request)
    {
        // dd($request->all());
        $invform = new VmtInvForm;
        $invform->form_name = $request->form_name;
        $invform->save();

        Excel::import(new VmtInvSectionImport($invform->id), $request->file);



        return "save successfully";
    }


    public function testinginestmentsection()
    {


        $query_form_details = VmtInvForm::where('form_name', 'investment 1')->first();
        // dd( $query_form_details);
        //Get the query structure
        //PSC0060

        $user_id = User::where('user_code', 'SA100')->first()->id;
        $year = "2023-01-01";

        //get assigned form id
        $query_fempAssigned_table = VmtInvFEmpAssigned::where('user_id', $user_id)
            // ->where('year', $year)
            ->first();

        $assigned_form_id = $query_fempAssigned_table->form_id;
        $f_emp_id = $query_fempAssigned_table->id;

        //Get the form template
        $query_inv_form_template = VmtInvFormSection::leftjoin('vmt_inv_section', 'vmt_inv_section.id', '=', 'vmt_inv_formsection.section_id')
            ->leftjoin('vmt_inv_section_group', 'vmt_inv_section_group.id', '=', 'vmt_inv_section.sectiongroup_id')
            ->leftjoin('vmt_inv_emp_formdata', 'vmt_inv_emp_formdata.fs_id', '=', 'vmt_inv_formsection.id')
            ->leftjoin('vmt_inv_f_emp_assigned', 'vmt_inv_f_emp_assigned.id', '=', 'vmt_inv_emp_formdata.f_emp_id')
            //  ->where('vmt_inv_formsection.form_id', $assigned_form_id)

            ->get(
                // [
                //     'vmt_inv_formsection.section_id',
                //     'vmt_inv_section.section',
                //     'vmt_inv_section.particular',
                //     'vmt_inv_section.reference',
                //     'vmt_inv_section.max_amount',
                //     'vmt_inv_section_group.section_group',
                //     'vmt_inv_formsection.id as fs_id',

                // ]
            )->toArray();

        dd($query_inv_form_template);
        // employee declaration amount
        $inv_emp_value = VmtInvFEmpAssigned::leftjoin('vmt_inv_emp_formdata', 'vmt_inv_emp_formdata.f_emp_id', '=', 'vmt_inv_f_emp_assigned.id')
            ->where('vmt_inv_f_emp_assigned.user_id', $user_id)->get();


        // json decode popup value;
        $popdecode = array();
        foreach ($inv_emp_value as $details_tem) {

            $rentalDetail['id'] = $details_tem["id"];
            $rentalDetail['user_id'] = $details_tem["user_id"];
            $rentalDetail['form_id'] = $details_tem["form_id"];
            $rentalDetail['f_emp_id'] = $details_tem["f_emp_id"];
            $rentalDetail['year'] = $details_tem["year"];
            $rentalDetail['fs_id'] = $details_tem["fs_id"];
            $rentalDetail['dec_amount'] = $details_tem["dec_amount"];
            $rentalDetail['json_popups_value'] = (json_decode($details_tem["json_popups_value"], true));
            array_push($popdecode, $rentalDetail);
        }
        ;

        $arr = array();
        foreach ($query_inv_form_template as $single_template) {
            foreach ($popdecode as $single_emp_env_value) {

                if ($single_template['fs_id'] == $single_emp_env_value['fs_id']) {
                    $single_template['id'] = $single_emp_env_value['id'];
                    $single_template['user_id'] = $single_emp_env_value['user_id'];
                    $single_template['form_id'] = $single_emp_env_value['form_id'];
                    $single_template['year'] = $single_emp_env_value['year'];
                    $single_template['f_emp_id'] = $single_emp_env_value['f_emp_id'];
                    $single_template['dec_amount'] = $single_emp_env_value['dec_amount'];
                    $single_template['json_popups_value'] = $single_emp_env_value['json_popups_value'];
                }
            }
            array_push($arr, $single_template);
        }

        $query_inv_form_template = $arr;


        $count = 0;
        foreach ($query_inv_form_template as $single_inv_form_template) {

            if (!array_key_exists($single_inv_form_template["section_group"], $query_inv_form_template)) {
                $query_inv_form_template[$single_inv_form_template["section_group"]] = array();
                array_push($query_inv_form_template[$single_inv_form_template["section_group"]], $single_inv_form_template);
            } else {
                array_push($query_inv_form_template[$single_inv_form_template["section_group"]], $single_inv_form_template);
            }

            //remove from outer json
            unset($query_inv_form_template[$count]);

            $count++;
        }
        dd($query_inv_form_template);



        $response["form_name"] = $query_form_details->form_name;
        $response["form_details"] = $query_inv_form_template;





        return response()->json([
            "status" => "success",
            "message" => "",
            "data" => $response,
        ]);
    }


    public function testEmployeeDocumentsJoin(Request $request)
    {
        // $user_id = User::where('user_code', auth()->user()->user_code)->first()->id;

        $v_form_template = VmtInvFormSection::join('vmt_inv_section', 'vmt_inv_section.id', '=', 'vmt_inv_formsection.section_id')
            ->join('vmt_inv_section_group', 'vmt_inv_section_group.id', '=', 'vmt_inv_section.sectiongroup_id')
            ->join('vmt_inv_emp_formdata', 'vmt_inv_emp_formdata.fs_id', '=', 'vmt_inv_formsection.id')
            ->join('vmt_inv_f_emp_assigned', 'vmt_inv_f_emp_assigned.id', '=', 'vmt_inv_emp_formdata.f_emp_id')
            ->join('users', 'users.id', '=', 'vmt_inv_f_emp_assigned.user_id')->orderBy('name', 'asc')
            ->get();
        return $v_form_template;
    }

    public function jobsmail()
    {

        $jobs = (new sendemailjobs())
            ->delay(Carbon::now()->addSeconds(5));

        dispatch($jobs);

        return "mail send successfully";
    }

    public function test_getTeamEmployeesLeaveDetails(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        return $serviceVmtAttendanceService->getTeamEmployeesLeaveDetails("MC0005", 5, 2023, ["Approved", "Rejected", "Pending"]);
    }

    public function test_getAppointmentTemplates()
    {

        $data =
            [
                "can_onboard_employee" => "1",
                "emp_client_code" => "IMA",
                "employee_code" => "IMA43857",
                "doj" => "2023-08-14",
                "ctc_in_words" => "one lakh forty-seven thousand four hundred sixty-three",
                "aadhar_number" => "4134 3214 3214",
                "passport_number" => null,
                "bank_id" => "1",
                "employee_name" => "vishnu",
                "gender" => "Male",
                "pan_number" => "kfoPi4354i",
                "passport_date" => null,
                "AccountNumber" => "524354354543",
                "dob" => "2000-01-17",
                "mobile_number" => "4325245435",
                "dl_no" => "353453",
                "blood_group_name" => "2",
                "bank_ifsc" => "INIB000K001",
                "marital_status" => "1",
                "email" => "vishnu@abshrms.com",
                "nationality" => "Indian",
                "physically_challenged" => "no",
                "current_address_line_1" => "dsasdsa",
                "current_address_line_2" => "sdsa",
                "current_country" => "5",
                "current_state" => "4",
                "current_city" => "Chennai",
                "current_pincode" => "213123",
                "permanent_address_line_1" => "dsasdsa",
                "permanent_address_line_2" => "sdsa",
                "permanent_country" => "5",
                "permanent_state" => "4",
                "permanent_city" => "Chennai",
                "permanent_pincode" => "213123",
                "department" => "1",
                "process" => null,
                "designation" => "IT",
                "cost_center" => null,
                "probation_period" => null,
                "work_location" => "Chennai",
                "l1_manager_code_id" => "PSC0060",
                "holiday_location" => null,
                "officical_mail" => null,
                "official_mobile" => null,
                "emp_notice" => null,
                "confirmation_period" => "2023-08-17",
                "father_name" => "Appa",
                "dob_father" => "1990-01-09",
                "father_gender" => "Male",
                "father_age" => "33",
                "mother_name" => "Amma",
                "dob_mother" => "1992-05-26",
                "mother_gender" => "Female",
                "mother_age" => "31",
                "spouse_name" => null,
                "wedding_date" => null,
                "spouse_gender" => "Female",
                "dob_spouse" => null,
                "no_of_children" => null,
                "basic" => "2547192",
                "hra" => "1273596",
                "statutory_bonus" => "32432",
                "child_education_allowance" => "34",
                "food_coupon" => "324",
                "lta" => "324",
                "special_allowance" => "1240158",
                "other_allowance" => "324",
                "gross" => "5094384",
                "epf_employer_contribution" => "1800",
                "graduity" => "324",
                "insurance" => "323.75",
                "cic" => "5096831",
                "epf_employee" => "1800",
                "esic_employee" => "0",
                "esic_employer_contribution" => "0",
                "professional_tax" => null,
                "labour_welfare_fund" => null,
                "net_income" => "5092584",
                "releivingDoc" => null,
                "voterId" => null,
                "passport" => null,
                "dlDoc" => null,
                'food_coupon_monthly' => 0,
                'food_coupon_yearly' => 0,
                'lta_monthly' => 0,
                'lta_yearly' => 0,
                'CEA_yearly' => 0,
                'CEA_monthly' => 0,
                "basic_monthly" => 13143,
                "basic_yearly" => 10,
                "hra_monthly" => 253255,
                "hra_yearly" => 9683968,
                "spl_allowance_monthly" => 336363,
                "spl_allowance_yearly" => 53366,
                "gross_monthly" => 2664666,
                "gross_yearly" => 43666,
                "employer_epf_monthly" => 251515,
                "employer_epf_yearly" => 25355,
                "employer_esi_monthly" => 2555,
                "employer_esi_yearly" => 5232525,
                "ctc_monthly" => 25255,
                "ctc_yearly" => 2525255,
                "employee_epf_monthly" => 2353436,
                "employee_epf_yearly" => 35255,
                "employee_esi_monthly" => 2555,
                "employee_esi_yearly" => 5232525,
                "employer_pt_monthly" => 35255525252,
                "employer_pt_yearly" => 532525525,
                "net_take_home_monthly" => 352535,
                "net_take_home_yearly" => 52235,
            ];

        $VmtClientMaster = VmtClientMaster::first();
        $image_view = url('/') . $VmtClientMaster->client_logo;
        $appoinmentPath = "";
        $client_name = strtolower(str_replace(' ', '_', sessionGetSelectedClientName()));
        //dd($client_name);
        $html = view('dynamic_payslip_templates.appointment_letter_langro_india_pvt_ltd', $data);
        //    return  $html;
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
        $isSent = \Mail::to('vishnu@abshrms.com')->send(new WelcomeMail("ABS123", 'Abs@123123', request()->getSchemeAndHttpHost(), $appoinmentPath, $image_view, $VmtClientMaster->client_code));
    }

    public function Tesingtdsworksheet(Request $request)
    {


        // $html = view('dynamic_payslip_templates.dynamic_payslip_v2');

        // // return $html;

        // $options = new Options();
        // $options->set('isHtml5ParserEnabled', true);
        // $options->set('isRemoteEnabled', true);

        // $pdf = new Dompdf($options);
        // $pdf->loadhtml($html, 'UTF-8');
        // $pdf->setPaper('A4', 'portrait');
        // $pdf->render();

        // $docUploads =  $pdf->stream();

        $start_date = '2023-07-01';
        $single_users = '194';

        $payslip_id = VmtPayroll::join('vmt_emp_payroll', 'vmt_emp_payroll.payroll_id', '=', 'vmt_payroll.id')
            ->where('vmt_payroll.payroll_date', $start_date)
            ->where('vmt_emp_payroll.user_id', $single_users)
            ->first([
                'vmt_emp_payroll.id as id'
            ]);

        // dd($payslip_id);


        $payslip_details = AbsSalaryProjection::where('vmt_emp_payroll_id', $payslip_id->id)->get()->toarray();

        dd($payslip_details);
    }
    public function tdsProjection(Request $request)
    {

        try {
            DB::table('abs_salary_projection')->truncate();
            $client_details = VmtClientMaster::Where('client_fullname', "!=", "All")->get(['id', 'client_name'])->toarray();


            for ($i = 0; $i < count($client_details); $i++) {


                $timeperiod = VmtOrgTimePeriod::where('status', '1')->first();
                $start_date = Carbon::parse($timeperiod->start_date)->format('Y-m-d');

                $end_date = Carbon::parse($timeperiod->end_date)->format('Y-m-01');
                $end_date = Carbon::parse($end_date)->format('Y-m-d');
                $current_date = Carbon::now();


                $existing_employee_data = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                    ->where('client_id', $client_details[$i]['id'])->where('users.active', "1")->where('users.is_ssa', "0")->get(['users.id', 'vmt_employee_details.doj', 'users.client_id'])->toarray();
                //dd($existing_employee_data);


                foreach ($existing_employee_data as $key => $single_users) {


                    $fin_end_date = Carbon::parse($timeperiod->end_date);

                    if ($single_users['doj'] < $start_date) {

                        $fin_start_date = Carbon::parse($timeperiod->start_date);
                    } else if (Carbon::parse($single_users['doj'])->format('m') != Carbon::parse($current_date)->format('m')) {

                        $fin_start_date = Carbon::parse($single_users['doj']);
                    }

                    $date_range = CarbonPeriod::create($fin_start_date->startOfMonth()->format('Y-m-d'), '1 month', $current_date->subMonths()->endOfMonth()->format('Y-m-d'));


                    $finyear_date_range = CarbonPeriod::create($fin_start_date->startOfMonth()->format('Y-m-d'), '1 month', $fin_end_date->endOfMonth()->format('Y-m-d'));


                    $previous_month_payslip_date = array();
                    $financial_year_date = array();

                    foreach ($date_range as $key => $single_date) {

                        $payroll_date = $single_date->format('Y-m-d');

                        $previous_month_payslip_date[] = $payroll_date;
                    }

                    foreach ($finyear_date_range as $key => $single_fin_date) {

                        $fin_year_date = $single_fin_date->format('Y-m-d');

                        $financial_year_date[] = $fin_year_date;
                    }
                    //dd($previous_month_payslip_date, $financial_year_date);

                    foreach ($previous_month_payslip_date as $key => $single_month) {

                        foreach ($financial_year_date as $key => $single_fin_month) {

                            $emp_payroll = '';

                            $payroll_date = VmtPayroll::where('payroll_date', $single_month)->where('client_id', $single_users['client_id'])->first();

                            if (!empty($payroll_date)) {
                                $emp_payroll = VmtEmployeePayroll::where('payroll_id', $payroll_date->id)->where('user_id', $single_users['id'])->first();
                            }


                            $res = array();

                            if ($single_fin_month == $single_month) {

                                $payslip_id = VmtPayroll::join('vmt_emp_payroll', 'vmt_emp_payroll.payroll_id', '=', 'vmt_payroll.id')
                                    ->where('vmt_payroll.payroll_date', $single_month)
                                    ->where('vmt_emp_payroll.user_id', $single_users['id'])
                                    ->first(['vmt_emp_payroll.id as id']);
                                if (!empty($payslip_id)) {

                                    $payslip_details = VmtEmployeePaySlipV2::where('emp_payroll_id', $payslip_id->id)->first();
                                }

                                if (!empty($payslip_details)) {

                                    if (!empty($emp_payroll)) {

                                        $salary_project_data = new AbsSalaryProjection;
                                        $salary_project_data->vmt_emp_payroll_id = $emp_payroll->id;
                                        $salary_project_data->payroll_months = $single_fin_month;
                                        $salary_project_data->basic = $payslip_details['basic'];
                                        $salary_project_data->hra = $payslip_details['hra'];
                                        $salary_project_data->child_edu_allowance = $payslip_details['child_edu_allowance'];
                                        $salary_project_data->spl_alw = $payslip_details['spl_alw'];
                                        $salary_project_data->total_fixed_gross = $payslip_details['total_fixed_gross'];
                                        $salary_project_data->month_days = $payslip_details['month_days'];
                                        $salary_project_data->worked_Days = $payslip_details['worked_Days'];
                                        $salary_project_data->arrears_Days = $payslip_details['arrears_Days'];
                                        $salary_project_data->lop = $payslip_details['lop'];
                                        $salary_project_data->earned_basic = $payslip_details['earned_basic'];
                                        $salary_project_data->basic_arrear = $payslip_details['basic_arrear'];
                                        $salary_project_data->earned_hra = $payslip_details['earned_hra'];
                                        $salary_project_data->hra_arrear = $payslip_details['hra_arrear'];
                                        $salary_project_data->earned_child_edu_allowance = $payslip_details['earned_child_edu_allowance'];
                                        $salary_project_data->earned_child_edu_allowance = $payslip_details['child_edu_allowance_arrear'];
                                        $salary_project_data->earned_spl_alw = $payslip_details['earned_spl_alw'];
                                        $salary_project_data->earned_spl_alw = $payslip_details['spl_alw_arrear'];
                                        $salary_project_data->overtime = $payslip_details['overtime'];
                                        $salary_project_data->total_earned_gross = $payslip_details['total_earned_gross'];
                                        $salary_project_data->pf_wages = $payslip_details['pf_wages'];
                                        $salary_project_data->pf_wages_arrear_epfr = $payslip_details['pf_wages_arrear_epfr'];
                                        $salary_project_data->epfr = $payslip_details['epfr'];
                                        $salary_project_data->epfr_arrear = $payslip_details['epfr_arrear'];
                                        $salary_project_data->edli_charges = $payslip_details['edli_charges'];
                                        $salary_project_data->edli_charges_arrears = $payslip_details['edli_charges_arrears'];
                                        $salary_project_data->pf_admin_charges = $payslip_details['pf_admin_charges'];
                                        $salary_project_data->pf_admin_charges_arrears = $payslip_details['pf_admin_charges_arrears'];
                                        $salary_project_data->employer_esi = $payslip_details['employer_esi'];
                                        $salary_project_data->employer_lwf = $payslip_details['employer_lwf'];
                                        $salary_project_data->ctc = $payslip_details['ctc'];
                                        $salary_project_data->epf_ee = $payslip_details['epf_ee'];
                                        $salary_project_data->employee_esic = $payslip_details['employee_esic'];
                                        $salary_project_data->prof_tax = $payslip_details['prof_tax'];
                                        $salary_project_data->income_tax = $payslip_details['income_tax'];
                                        $salary_project_data->sal_adv = $payslip_details['sal_adv'];
                                        $salary_project_data->canteen_dedn = $payslip_details['canteen_dedn'];
                                        $salary_project_data->other_deduc = $payslip_details['other_deduc'];
                                        $salary_project_data->lwf = $payslip_details['lwf'];
                                        $salary_project_data->total_deductions = $payslip_details['total_deductions'];
                                        $salary_project_data->net_take_home = $payslip_details['net_take_home'];
                                        $salary_project_data->rupees = $payslip_details['rupees'];
                                        $salary_project_data->el_opn_bal = $payslip_details['el_opn_bal'];
                                        $salary_project_data->availed_el = $payslip_details['availed_el'];
                                        $salary_project_data->balance_el = $payslip_details['balance_el'];
                                        $salary_project_data->sl_opn_bal = $payslip_details['sl_opn_bal'];
                                        $salary_project_data->availed_sl = $payslip_details['availed_sl'];
                                        $salary_project_data->balance_sl = $payslip_details['balance_sl'];
                                        $salary_project_data->rename = $payslip_details['rename'];
                                        $salary_project_data->greetings = $payslip_details['greetings'];
                                        $salary_project_data->stats_bonus = $payslip_details['stats_bonus'];
                                        $salary_project_data->email = $payslip_details['email'];
                                        $salary_project_data->earned_stats_bonus = $payslip_details['earned_stats_bonus'];
                                        $salary_project_data->earned_stats_arrear = $payslip_details['earned_stats_arrear'];
                                        $salary_project_data->travel_conveyance = $payslip_details['travel_conveyance'];
                                        $salary_project_data->other_earnings = $payslip_details['other_earnings'];
                                        $salary_project_data->save();
                                    }
                                } else {
                                    return 'no payslip data found for ' . $single_users['id'] . 'user' . " " . $single_month . " " . $single_fin_month;
                                }

                                array_push($res, $payslip_details);
                            } else {

                                $compensatory_details = User::join('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'users.id')->where('user_id', $single_users['id'])->first();

                                $salary_project_data = new AbsSalaryProjection;

                                if (!empty($emp_payroll)) {

                                    $salary_project_data->vmt_emp_payroll_id = $emp_payroll->id;
                                    $salary_project_data->payroll_months = $single_fin_month;
                                    $salary_project_data->basic = $payslip_details['basic'] ?? 0;
                                    $salary_project_data->hra = $payslip_details['hra'] ?? 0;
                                    $salary_project_data->child_edu_allowance = $payslip_details['child_education_allowance'] ?? 0;
                                    $salary_project_data->spl_alw = $payslip_details['spl_alw'] ?? 0;
                                    $salary_project_data->total_fixed_gross = $payslip_details['gross'] ?? 0;
                                    $salary_project_data->month_days = $payslip_details['month_days'] ?? 0;
                                    $salary_project_data->worked_Days = $payslip_details['worked_Days'] ?? 0;
                                    $salary_project_data->arrears_Days = $payslip_details['arrears_Days'] ?? 0;
                                    $salary_project_data->lop = $payslip_details['lop'] ?? 0;
                                    $salary_project_data->earned_basic = $payslip_details['basic'] ?? 0;
                                    $salary_project_data->basic_arrear = $payslip_details['basic_arrear'] ?? 0;
                                    $salary_project_data->earned_hra = $payslip_details['hra'] ?? 0;
                                    $salary_project_data->hra_arrear = $payslip_details['hra_arrear'] ?? 0;
                                    $salary_project_data->earned_child_edu_allowance = $payslip_details['child_education_allowance'] ?? 0;
                                    $salary_project_data->earned_child_edu_allowance = $payslip_details['child_edu_allowance_arrear'] ?? 0;
                                    $salary_project_data->earned_spl_alw = $payslip_details['special_allowance'] ?? 0;
                                    $salary_project_data->earned_spl_alw = $payslip_details['spl_alw_arrear'] ?? 0;
                                    $salary_project_data->overtime = $payslip_details['overtime'] ?? 0;
                                    $salary_project_data->total_earned_gross = $payslip_details['gross'] ?? 0;
                                    $salary_project_data->pf_wages = $payslip_details['pf_wages'] ?? 0;
                                    $salary_project_data->pf_wages_arrear_epfr = $payslip_details['pf_wages_arrear_epfr'] ?? 0;
                                    $salary_project_data->epfr = $payslip_details['epfr'] ?? 0;
                                    $salary_project_data->epfr_arrear = $payslip_details['epfr_arrear'] ?? 0;
                                    $salary_project_data->edli_charges = $payslip_details['edli_charges'] ?? 0;
                                    $salary_project_data->edli_charges_arrears = $payslip_details['edli_charges_arrears'] ?? 0;
                                    $salary_project_data->pf_admin_charges = $payslip_details['pf_admin_charges'] ?? 0;
                                    $salary_project_data->pf_admin_charges_arrears = $payslip_details['pf_admin_charges_arrears'] ?? 0;
                                    $salary_project_data->employer_esi = $payslip_details['esic_employer_contribution'] ?? 0;
                                    $salary_project_data->employer_lwf = $payslip_details['employer_lwf'] ?? 0;
                                    $salary_project_data->ctc = $payslip_details['cic'] ?? 0;
                                    $salary_project_data->epf_ee = $payslip_details['epf_employee'] ?? 0;
                                    $salary_project_data->employee_esic = $payslip_details['esic_employee'] ?? 0;
                                    $salary_project_data->prof_tax = $payslip_details['professional_tax'] ?? 0;
                                    $salary_project_data->income_tax = $payslip_details['income_tax'] ?? 0;
                                    $salary_project_data->sal_adv = $payslip_details['sal_adv'] ?? 0;
                                    $salary_project_data->canteen_dedn = $payslip_details['canteen_dedn'] ?? 0;
                                    $salary_project_data->other_deduc = $payslip_details['other_deduc'] ?? 0;
                                    $salary_project_data->lwf = $payslip_details['lwf'] ?? 0;
                                    $salary_project_data->total_deductions = $payslip_details['total_deductions'] ?? 0;
                                    $salary_project_data->net_take_home = $payslip_details['net_income'] ?? 0;
                                    $salary_project_data->rupees = $payslip_details['rupees'] ?? 0;
                                    $salary_project_data->el_opn_bal = $payslip_details['el_opn_bal'] ?? 0;
                                    $salary_project_data->availed_el = $payslip_details['availed_el'] ?? 0;
                                    $salary_project_data->balance_el = $payslip_details['balance_el'] ?? 0;
                                    $salary_project_data->sl_opn_bal = $payslip_details['sl_opn_bal'] ?? 0;
                                    $salary_project_data->availed_sl = $payslip_details['availed_sl'] ?? 0;
                                    $salary_project_data->balance_sl = $payslip_details['balance_sl'] ?? 0;
                                    $salary_project_data->rename = $payslip_details['rename'] ?? 0;
                                    $salary_project_data->greetings = $payslip_details['greetings'] ?? 0;
                                    $salary_project_data->stats_bonus = $payslip_details['stats_bonus'] ?? 0;
                                    $salary_project_data->email = $payslip_details['email'] ?? 0;
                                    $salary_project_data->earned_stats_bonus = $payslip_details['Statutory_bonus'] ?? 0;
                                    $salary_project_data->earned_stats_arrear = $payslip_details['earned_stats_arrear'] ?? 0;
                                    $salary_project_data->travel_conveyance = $payslip_details['travel_conveyance'] ?? 0;
                                    $salary_project_data->other_earnings = $payslip_details['other_earnings'] ?? 0;
                                    $salary_project_data->save();
                                }


                                array_push($res, $compensatory_details);
                            }
                        }
                    }
                }
            }
            return $response = ([
                'status ' => "success",
                "message" => "",
                "data" => ""
            ]);
        } catch (\Exception $e) {
            return $response = ([
                "status" => "failure",
                "user_data" => $single_users['id'] . " " . $single_month,
                "user_month" => $single_users['id'] . " " . $single_month,
                "data" => $e->getmessage() . "" . $e->getline()
            ]);
        }
    }
    public function fetchInvestmentTaxReports()
    {
        $reportsdata = array();

        $client_id = "3";

        $payroll_month = "2023-05-01";

        // $inv_emp = VmtInvFEmpAssigned::where()->pluck('user_id')->toArray();

        $inv_emp = ['144', '194', '176'];

        $Employee_details = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
            ->leftjoin('vmt_employee_statutory_details', 'vmt_employee_statutory_details.user_id', '=', 'users.id')
            ->where("users.active", "1")
            ->where("users.client_id", $client_id)
            ->whereIn("users.id", $inv_emp)
            ->get([
                'users.id as user_id',
                'users.user_code as Employee Code',
                'users.name as Employee Name',
                'vmt_employee_details.gender as Gender',
                'vmt_employee_details.pan_number as PAN Number',
                'vmt_employee_details.dob as Date Of Birth',
                'vmt_employee_details.doj as Date Of Joining',
                'vmt_employee_statutory_details.tax_regime as Tax Regime'
            ]);

        $employee_salary_details = array();

        foreach ($Employee_details as $key => $single_user) {

            $payroll_date = VmtPayroll::where('payroll_date', $payroll_month)->where('client_id', $client_id)->first();

            if (!empty($payroll_date)) {

                $emp_payroll = VmtEmployeePayroll::where('payroll_id', $payroll_date->id)->where('user_id', $single_user['user_id']);
            }

            if ($emp_payroll->exists()) {
                $emp_payroll = $emp_payroll->first();
                $employee_projected_salary = AbsSalaryProjection::where('vmt_emp_payroll_id', $emp_payroll->id);
            }

            if ($employee_projected_salary->exists()) {

                $employee_salary_details[$key]["Employee Code"] = $single_user['Employee Code'];
                $employee_salary_details[$key]["Employee Name"] = $single_user['Employee Name'];
                $employee_salary_details[$key]["Gender"] = $single_user['Gender'];
                $employee_salary_details[$key]["PAN Number"] = $single_user['PAN Number'];
                $employee_salary_details[$key]["Date Of Birth"] = $single_user['Date Of Birth'];
                $employee_salary_details[$key]["Date Of Joining"] = $single_user['Date Of Joining'];
                $employee_salary_details[$key]["Tax Regime"] = $single_user['Tax Regime'];
                $employee_salary_details[$key]["Basic"] = $employee_projected_salary->sum('earned_basic');
                $employee_salary_details[$key]["Basic Arrears"] = $employee_projected_salary->sum('basic_arrear');
                $employee_salary_details[$key]["Dearness Allowance"] = $employee_projected_salary->sum('dearness_allowance_earned');
                $employee_salary_details[$key]["Dearness Allowance Arrears"] = $employee_projected_salary->sum('dearness_allowance_arrear');
                $employee_salary_details[$key]["Variable Dearness Allowance"] = $employee_projected_salary->sum('vda_earned');
                $employee_salary_details[$key]["Vairable Dearness Allowance Arrears"] = $employee_projected_salary->sum('vda_arrear');
                $employee_salary_details[$key]["HRA"] = $employee_projected_salary->sum('earned_hra');
                $employee_salary_details[$key]["HRA Arrears"] = $employee_projected_salary->sum('hra_arrear');
                $employee_salary_details[$key]["Child Education Allowance"] = $employee_projected_salary->sum('earned_child_edu_allowance');
                $employee_salary_details[$key]["Child Education Allowance Arrears"] = $employee_projected_salary->sum('child_edu_allowance_arrear');
                $employee_salary_details[$key]["Statutory Bonus"] = $employee_projected_salary->sum('earned_stats_bonus');
                $employee_salary_details[$key]["Statutory Bonus Arrears"] = $employee_projected_salary->sum('earned_stats_arrear');
                $employee_salary_details[$key]["Medical Allowance"] = $employee_projected_salary->sum('medical_allowance_earned');
                $employee_salary_details[$key]["Medical Allowance Arrears"] = $employee_projected_salary->sum('medical_allowance_arrear');
                $employee_salary_details[$key]["Communicaton Allowance"] = $employee_projected_salary->sum('communication_allowance_earned');
                $employee_salary_details[$key]["Communication Allowance Arrears"] = $employee_projected_salary->sum('communication_allowance_arrear');
                $employee_salary_details[$key]["Leave Travel Allowance"] = $employee_projected_salary->sum('earned_lta');
                $employee_salary_details[$key]["Leave Travel Allowance Arrears"] = $employee_projected_salary->sum('lta_arrear');
                $employee_salary_details[$key]["Food Allowance"] = $employee_projected_salary->sum('food_allowance_earned');
                $employee_salary_details[$key]["Food Allowance Arrear"] = $employee_projected_salary->sum('food_allowance_arrear');
                $employee_salary_details[$key]["Special Allowance"] = $employee_projected_salary->sum('earned_spl_alw');
                $employee_salary_details[$key]["Special Allowance Arrears"] = $employee_projected_salary->sum('spl_alw_arrear');
                $employee_salary_details[$key]["Other Allowance"] = $employee_projected_salary->sum('other_allowance_earned');
                $employee_salary_details[$key]["Other Allowance Arrears"] = $employee_projected_salary->sum('other_allowance_arrear');
                $employee_salary_details[$key]["Washing Allowance"] = $employee_projected_salary->sum('washing_allowance_earned');
                $employee_salary_details[$key]["Washing Allowance Arrears"] = $employee_projected_salary->sum('washing_allowance_arrear');
                $employee_salary_details[$key]["Uniform Allowance"] = $employee_projected_salary->sum('uniform_allowance_earned');
                $employee_salary_details[$key]["Uniform Allowance Arrears"] = $employee_projected_salary->sum('uniform_allowance_arrear');
                $employee_salary_details[$key]["Vehicle Reimbursement"] = $employee_projected_salary->sum('vehicle_reimbursement_earned');
                $employee_salary_details[$key]["Vehicle Reimbursement Arrears"] = $employee_projected_salary->sum('vehicle_reimbursement_arrear');
                $employee_salary_details[$key]["Driver Salary Reimbursment"] = $employee_projected_salary->sum('driver_salary_earned');
                $employee_salary_details[$key]["Driver Salary Reimbursment Arrears"] = $employee_projected_salary->sum('driver_salary_arrear');
                $employee_salary_details[$key]["Overtime"] = $employee_projected_salary->sum('overtime');
                $employee_salary_details[$key]["Overtime Arrears"] = $employee_projected_salary->sum('overtime_arrear');
                $employee_salary_details[$key]["Arrears"] = $employee_projected_salary->sum('basic_arrear') + $employee_projected_salary->sum('dearness_allowance_arrear') + $employee_projected_salary->sum('vda_arrear') + $employee_projected_salary->sum('hra_arrear') + $employee_projected_salary->sum('hra_arrear') +
                    $employee_projected_salary->sum('child_edu_allowance_arrear') + $employee_projected_salary->sum('earned_stats_arrear') + $employee_projected_salary->sum('medical_allowance_arrear')
                    + $employee_projected_salary->sum('communication_allowance_arrear') + $employee_projected_salary->sum('food_allowance_arrear') + $employee_projected_salary->sum('lta_arrear') + $employee_projected_salary->sum('spl_alw_arrear') + $employee_projected_salary->sum('other_allowance_arrear')
                    + $employee_projected_salary->sum('washing_allowance_arrear') + $employee_projected_salary->sum('uniform_allowance_arrear') + $employee_projected_salary->sum('vehicle_reimbursement_arrear') + $employee_projected_salary->sum('driver_salary_arrear');


                $employee_salary_details[$key]["Incentive"] = $employee_projected_salary->sum('incentive');
                ;
                $employee_salary_details[$key]["Other Earnings"] = $employee_projected_salary->sum('other_earnings');
                $employee_salary_details[$key]["Referral Bonus"] = $employee_projected_salary->sum('referral_bonus');
                $employee_salary_details[$key]["Annual Statutory Bonus"] = $employee_projected_salary->sum('earned_stats_bonus');
                $employee_salary_details[$key]["Ex-Gratia"] = $employee_projected_salary->sum('ex_gratia');
                $employee_salary_details[$key]["Attendance Bonus"] = $employee_projected_salary->sum('attendance_bonus');
                $employee_salary_details[$key]["Daily Allowance"] = $employee_projected_salary->sum('daily_allowance');
                $employee_salary_details[$key]["Leave Encashments"] = $employee_projected_salary->sum('leave_encashment');
                $employee_salary_details[$key]["Gift"] = $employee_projected_salary->sum('gift_payment');
                $employee_salary_details[$key]["Annual Gross Salary"] = $employee_projected_salary->sum('earned_basic') + $employee_projected_salary->sum('dearness_allowance_earned') + $employee_projected_salary->sum('vda_earned')
                    + $employee_projected_salary->sum('earned_hra') + $employee_projected_salary->sum('earned_child_edu_allowance') + $employee_projected_salary->sum('medical_allowance_earned')
                    + $employee_projected_salary->sum('communication_allowance_earned') + $employee_projected_salary->sum('earned_lta') + $employee_projected_salary->sum('food_allowance_earned')
                    + $employee_projected_salary->sum('earned_spl_alw') + $employee_projected_salary->sum('other_allowance_earned') + $employee_projected_salary->sum('washing_allowance_earned') +
                    $employee_projected_salary->sum('uniform_allowance_earned');
            }
        }

        $salary_data['headers'] = array(
            'Employee Code',
            'Employee Name',
            'Gender',
            'PAN Number',
            'Date Of Birth',
            'Date Of Joining',
            'Tax Regime',
            'Basic',
            'Basic Arrears',
            'Dearness Allowance',
            'Dearness Allowance Arrears',
            'Variable Dearness Allowance',
            'Vairable Dearness Allowance Arrears',
            'HRA',
            'HRA Arrears',
            'Child Education Allowance',
            'Child Education Allowance Arrears',
            'Statutory Bonus',
            'Statutory Bonus Arrears',
            'Medical Allowance',
            'Medical Allowance Arrears',
            'Communicaton Allowance',
            'Communication Allowance Arrears',
            'Leave Travel Allowance',
            'Leave Travel Allowance Arrears',
            'Food Allowance',
            'Food Allowance Arrears',
            'Special Allowance',
            'Special Allowance Arrears',
            'Other Allowance',
            'Other Allowance Arrears',
            'Washing Allowance',
            'Washing Allowance Arrears',
            'Uniform Allowance',
            'Uniform Allowance Arrears',
            'Vehicle Reimbursement',
            'Vehicle Reimbursement Arrears',
            'Driver Salary Reimbursment',
            'Driver Salary Reimbursment Arrears',
            'Arrears',
            'Overtime',
            'Overtime Arrears',
            'Incentive',
            'Other Earnings',
            'Referral Bonus',
            'Annual Statutory Bonus',
            'Ex-Gratia',
            'Attendance Bonus',
            'Daily Allowance',
            'Leave Encashments',
            'Gift',
            'Annual Gross Salary'
        );
        $v_form_template = array();
        $v_form_template = array();

        foreach ($inv_emp as $form_key => $single_inv_users) {

            $v_form_template[] = VmtInvFormSection::leftjoin('vmt_inv_section', 'vmt_inv_section.id', '=', 'vmt_inv_formsection.section_id')
                ->leftjoin('vmt_inv_section_group', 'vmt_inv_section_group.id', '=', 'vmt_inv_section.sectiongroup_id')
                ->leftjoin('vmt_inv_emp_formdata', 'vmt_inv_emp_formdata.fs_id', '=', 'vmt_inv_formsection.id')
                ->leftjoin('vmt_inv_f_emp_assigned', 'vmt_inv_f_emp_assigned.id', '=', 'vmt_inv_emp_formdata.f_emp_id')
                ->leftjoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'vmt_inv_f_emp_assigned.user_id')
                ->leftjoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'vmt_employee_compensatory_details.user_id')
                ->where('vmt_inv_f_emp_assigned.user_id', $single_inv_users)
                ->get(
                    [
                        'vmt_inv_section_group.section_group',
                        'vmt_inv_section.section',
                        'vmt_inv_section.particular',
                        'vmt_inv_emp_formdata.dec_amount',
                        'vmt_inv_section.max_amount',
                        'vmt_inv_emp_formdata.json_popups_value',
                        'vmt_inv_f_emp_assigned.regime',
                        'vmt_inv_f_emp_assigned.updated_at',
                        'vmt_employee_compensatory_details.gross',
                        'vmt_employee_compensatory_details.basic',
                        'vmt_employee_compensatory_details.hra',
                        'vmt_employee_compensatory_details.special_allowance',
                        'vmt_employee_compensatory_details.professional_tax',
                        'vmt_employee_compensatory_details.child_education_allowance',
                        'vmt_employee_compensatory_details.lta',
                        'vmt_employee_details.doj',
                        'vmt_employee_details.dob',
                    ]
                )->toArray();
        }
        //  foreach($v_form_template as $dec_amt){

        //     dd($dec_amt);
        //  }

        // Excemption

        array_push($salary_data['headers'], 'HRA Exceptions');
        array_push($salary_data['headers'], 'CEA Exceptions');
        array_push($salary_data['headers'], 'LTA Exceptions');

        foreach ($Employee_details as $key => $single_user) {

            $hra_value = $this->HraExceptionCalc(User::where('user_code', $single_user['Employee Code'])->first()->id, $payroll_month);

            $employee_salary_details[$key]["HRA Exceptions"] = $hra_value;
            $employee_salary_details[$key]["CEA Exceptions"] = 0;
            $employee_salary_details[$key]["LTA Exceptions"] = 0;
        }


        // Previous employeer income

        foreach ($v_form_template as $dec_amt) {
            if ($dec_amt['section_group'] == 'Previous Employer Income') {
                array_push($salary_data['headers'], $dec_amt['particular']);
                foreach ($Employee_details as $key => $single_user) {
                    $employee_salary_details[$key][$dec_amt['particular']] = 0;
                }
                foreach ($Employee_details as $key => $single_user) {
                    if ($single_inv_users == User::where('user_code', $single_user['Employee Code'])->first()->id) {
                        $employee_salary_details[$key][$dec_amt['particular']] = $dec_amt['dec_amount'];
                    }
                }
            }
        }
        $sumofprevious_emp = 0;
        foreach ($v_form_template as $dec_amt) {
            if ($dec_amt['section_group'] == 'Previous Employer Income') {
                array_push($salary_data['headers'], "Total Gross Income");

                foreach ($Employee_details as $key => $single_user) {
                    if ($single_inv_users == User::where('user_code', $single_user['Employee Code'])->first()->id) {
                        $sumofprevious_emp += $dec_amt['dec_amount'];
                        $employee_salary_details[$key]["Total Gross Income"] = $sumofprevious_emp + $employee_salary_details[$key]["Annual Gross Salary"];
                    } else {
                        $employee_salary_details[$key]["Total Gross Income"] = $employee_salary_details[$key]["Annual Gross Salary"];
                    }
                }
            }
        }



        array_push(
            $salary_data['headers'],
            '(a) salary as per provision as containeds in sec.17(1)',
            '(b) Value of Prequisites u/s 17 (2)',
            '(c) Profits in lie u of salary under section 13(3)'
        );

        foreach ($Employee_details as $key => $single_user) {

            // if($single_inv_users == User::where('user_code',$single_user['Employee Code'])->first()->id){
            $employee_salary_details[$key]["(a) salary as per provision as containeds in sec.17(1)"] = 0;
            $employee_salary_details[$key]["(b) Value of Prequisites u/s 17 (2)"] = 0;
            $employee_salary_details[$key]["(c) Profits in lie u of salary under section 13(3)"] = 0;
            // }
        }

        $tax_reports_Section_column = [];

        $tax_reports_Excemption_column = [];

        $employee_section_details = [];

        $employee_excemption_details = [];

        // $v_form_template = array_values(array_filter($v_form_template));



        foreach ($v_form_template as $key => $single_user_data) {

            if (trim($single_user_data['section_group']) == 'Section 80C & 80CC') {

                if (!in_array($single_user_data['particular'], $tax_reports_Section_column)) {

                    array_push($tax_reports_Section_column, $single_user_data['particular']);
                    array_push($salary_data['headers'], $single_user_data['particular']);
                }
                $employee_salary_details[$form_key][$single_user_data['particular']] = $single_user_data['dec_amount'];
                $employee_section_details[$form_key][$single_user_data['particular']] = $single_user_data['dec_amount'];
            }
        }



        foreach ($v_form_template as $key => $single_user_data) {

            if (trim($single_user_data['section_group']) == 'Other Excemptions') {

                if (!in_array($single_user_data['particular'], $tax_reports_Excemption_column)) {

                    array_push($tax_reports_Excemption_column, $single_user_data['particular']);
                    array_push($salary_data['headers'], $single_user_data['particular']);
                }

                if ($single_user_data['dec_amount'] >= $single_user_data['max_amount']) {

                    $employee_salary_details[$form_key][$single_user_data['particular']] = $single_user_data['max_amount'];
                    $employee_excemption_details[$form_key][$single_user_data['particular']] = $single_user_data['max_amount'];
                } else {

                    $employee_salary_details[$form_key][$single_user_data['particular']] = $single_user_data['dec_amount'];
                    $employee_excemption_details[$form_key][$single_user_data['particular']] = $single_user_data['dec_amount'];
                }
            }
        }




        $section_count = 0;
        foreach ($employee_salary_details as $section_key => $single_section_data) {
            $section_count = $section_key;
            foreach ($tax_reports_Section_column as $key => $single_section_column) {

                if (!in_array($single_section_column, array_keys($single_section_data))) {

                    $employee_salary_details[$section_key][$single_section_column] = 0;
                    $employee_section_details[$section_key][$single_section_column] = 0;
                }
            }

            $Section_80CCE_total = array_sum($single_section_data);
            if ($Section_80CCE_total >= '150000') {

                $employee_salary_details[$section_count]['Section 80CCE Total'] = 150000;
                $section_count++;
            } else {
                $employee_salary_details[$section_count]['Section 80CCE Total'] = $Section_80CCE_total;
                $section_count++;
            }
        }
        foreach ($employee_excemption_details as $Excemption_key => $single_Excemption_data) {

            foreach ($tax_reports_Excemption_column as $key => $single_excemption_column) {

                if (!in_array($single_excemption_column, array_keys($single_Excemption_data))) {
                    $employee_excemption_details[$Excemption_key][$single_excemption_column] = 0;
                    $employee_salary_details[$Excemption_key][$single_excemption_column] = 0;
                }
            }

            $employee_salary_details[$Excemption_key]['10.Aggregate of deductible amount under Chapter VI-A'] = array_sum($single_Excemption_data) + $employee_salary_details[$Excemption_key]['Section 80CCE Total'];
        }

        $salary_data['rows'] = $employee_salary_details;

        array_push($reportsdata, array_unique($salary_data['headers']), $salary_data['rows']);

        return
            dd($reportsdata);
    }

    public function HraExceptionCalc($user_id, $month)
    {

        $timeperiod = VmtOrgTimePeriod::where('status', '1')->first();
        $start_date = Carbon::parse($timeperiod->start_date)->format('Y-m-d');

        $end_date = Carbon::parse($timeperiod->end_date)->format('Y-m-01');
        $end_date = Carbon::parse($end_date)->format('Y-m-d');

        $date_range = CarbonPeriod::create($start_date, '1 month', $end_date);


        $date = [];
        foreach ($date_range as $key => $value) {
            $date[] = $value->format('M Y');
        }

        $annual = $this->getAnnualProjection($user_id, $month);


        if (isset($annual['Total']['arrear_Hra'])) {
            $annual_Hra = $annual['Total']['arrear_Hra'] + $annual['Total']['Hra'];
        } else {
            $annual_Hra = $annual['Total']['Hra'];
        }


        if (isset($annual['Total']['arrear_basic'])) {
            $annual_basic = $annual['Total']['arrear_basic'] + $annual['Total']['Basic'];
        } else {
            $annual_basic = $annual['Total']['Basic'];
        }

        $annual_basic = $annual_basic * 0.5;

        $annual_basic10per = $annual_basic * 0.10;

        $excessOfRentPaid = $annual_basic10per - $annual_Hra;


        $res11 = ["total_earnedbasic" => $annual_basic, "total_hrareceived" => $annual_Hra, "Excess_of_rentpaid" => $excessOfRentPaid];

        $total_excep = min(array_values($res11));

        $res = ["total_earnedbasic" => $annual_basic, "total_hrareceived" => $annual_Hra, "Excess_of_rentpaid" => $excessOfRentPaid, "total_exception_amt" => $total_excep];


        foreach ($date as $single_date) {
            $HraException['month'] = $single_date;
            $HraException['Earned_basic'] = $annual_basic / 12;
            $HraException['Hra_received'] = round($annual_Hra / 12);
            $HraException['rent_paid_over_10per'] = round(($annual_basic10per - $annual_Hra) / 12);

            array_push($res, $HraException);
        }


        foreach ($res as $key => $value) {
            if (is_int($key)) {
                $min_value = min(array_values($res[$key]));
                $res[$key]['Exception_amt'] = $min_value;
            }
        }

        return($res);
    }
    public function getAnnualProjection($user_id, $month)
    {

        // $user_id = User::where('user_code', 'PSC0057')->first()->id;

        $start_date = $month;
        $single_users = $user_id;


        $payslip_id = VmtPayroll::join('vmt_emp_payroll', 'vmt_emp_payroll.payroll_id', '=', 'vmt_payroll.id')
            ->where('vmt_payroll.payroll_date', $start_date)
            ->where('vmt_emp_payroll.user_id', $single_users)
            ->first([
                'vmt_emp_payroll.id as id'
            ]);


        $payslip_details = AbsSalaryProjection::where('vmt_emp_payroll_id', $payslip_id->id)->get()->toarray();

        $timeperiod = VmtOrgTimePeriod::where('status', '1')->first();
        $start_date = Carbon::parse($timeperiod->start_date)->format('Y-m-d');

        $end_date = Carbon::parse($timeperiod->end_date)->format('Y-m-01');
        $end_date = Carbon::parse($end_date)->format('Y-m-d');
        $current_date = Carbon::now()->subMonth(2);

        $date_range = CarbonPeriod::create($start_date, '1 month', $end_date);

        $date = [];
        foreach ($date_range as $key => $value) {
            $date[] = $value;
        }

        $actual = [];
        $projection = [];
        $compensatory_value = [];
        $payroll_value = [];

        $single_basic = 0;
        $single_hra = 0;
        $single_cld_all = 0;
        $single_spl_alw = 0;
        $single_total_fixed_gross = 0;
        $single_earned_basic = 0;
        $single_basic_arrear = 0;
        $single_earned_hra = 0;
        $single_hra_arrear = 0;
        $single_earned_child_edu_allowance = 0;
        $single_child_edu_allowance_arrear = 0;
        $single_earned_spl_alw = 0;
        $single_spl_alw_arrear = 0;
        $single_overtime = 0;
        $single_total_earned_gross = 0;
        $single_pf_wages = 0;
        $single_pf_wages_arrear_epfr = 0;
        $single_epfr = 0;
        $single_epfr_arrear = 0;
        $single_edli_charges = 0;
        $single_edli_charges_arrears = 0;
        $single_pf_admin_charges = 0;
        $single_pf_admin_charges_arrears = 0;
        $single_employer_esi = 0;
        $single_employer_lwf = 0;
        $single_ctc = 0;
        $single_epf_ee = 0;
        $single_epf_ee_arrear = 0;
        $single_employee_esic = 0;
        $single_prof_tax = 0;
        $single_income_tax = 0;
        $single_sal_adv = 0;
        $single_canteen_dedn = 0;
        $single_other_deduc = 0;
        $single_lwf = 0;
        $single_stats_bonus = 0;
        $single_earned_stats_bonus = 0;
        $single_earned_stats_bonus_arrear = 0;
        $single_travel_conveyence = 0;
        $single_earned_stats_bonus = 0;

        $single_basic1 = 0;
        $single_hra1 = 0;
        $single_cld_all1 = 0;
        $single_spl_alw1 = 0;
        $single_total_fixed_gross1 = 0;
        $single_earned_basic1 = 0;
        $single_basic_arrear1 = 0;
        $single_earned_hra1 = 0;
        $single_hra_arrear1 = 0;
        $single_earned_child_edu_allowance1 = 0;
        $single_child_edu_allowance_arrear1 = 0;
        $single_earned_spl_alw1 = 0;
        $single_spl_alw_arrear1 = 0;
        $single_overtime1 = 0;
        $single_total_earned_gross1 = 0;
        $single_pf_wages1 = 0;
        $single_pf_wages_arrear_epfr1 = 0;
        $single_epfr1 = 0;
        $single_epfr_arrear1 = 0;
        $single_edli_charges1 = 0;
        $single_edli_charges_arrears1 = 0;
        $single_pf_admin_charges1 = 0;
        $single_pf_admin_charges_arrears1 = 0;
        $single_employer_esi1 = 0;
        $single_employer_lwf1 = 0;
        $single_ctc1 = 0;
        $single_epf_ee1 = 0;
        $single_epf_ee_arrear1 = 0;
        $single_employee_esic1 = 0;
        $single_prof_tax1 = 0;
        $single_income_tax1 = 0;
        $single_sal_adv1 = 0;
        $single_canteen_dedn1 = 0;
        $single_other_deduc1 = 0;
        $single_lwf1 = 0;
        $single_stats_bonus1 = 0;
        $single_earned_stats_bonus1 = 0;
        $single_earned_stats_bonus_arrear1 = 0;
        $single_travel_conveyence1 = 0;
        $single_earned_stats_bonus1 = 0;

        foreach ($date as $single_dates) {

            if ($single_dates->lte($current_date)) {
                foreach ($payslip_details as $key => $single_value) {

                    // dd($single_value);
                    if ($single_value['payroll_months'] == $single_dates->format('Y-m-d')) {

                        $single_basic += $single_value['basic'];
                        // $payroll_value['Basic'] = $single_basic;
                        // $single_hra += $single_value['hra'];
                        // $payroll_value['Hra'] = $single_hra;
                        $single_cld_all += $single_value['child_edu_allowance'];
                        $payroll_value['Child_allowance'] = $single_cld_all;
                        $single_spl_alw += $single_value['spl_alw'];
                        $payroll_value['Special_allowance'] = $single_spl_alw;
                        // $single_total_fixed_gross  += $single_value['total_fixed_gross'];
                        // $payroll_value['total_Fixed_Gross'] = $single_total_fixed_gross;
                        $single_earned_basic += $single_value['earned_basic'];
                        $payroll_value['Basic'] = $single_earned_basic;
                        $single_basic_arrear += $single_value['basic_arrear'];
                        $payroll_value['basic_arrear'] = $single_basic_arrear;
                        $single_earned_hra += $single_value['earned_hra'];
                        $payroll_value['Hra'] = $single_earned_hra;
                        $single_hra_arrear += $single_value['hra_arrear'];
                        $payroll_value['hra_arrear'] = $single_hra_arrear;
                        $single_earned_child_edu_allowance += $single_value['earned_child_edu_allowance'];
                        $payroll_value['earned_child_allowance'] = $single_earned_child_edu_allowance;
                        $single_child_edu_allowance_arrear += $single_value['child_edu_allowance_arrear'];
                        $payroll_value['children_allw_arrear'] = $single_child_edu_allowance_arrear;
                        $single_earned_spl_alw += $single_value['earned_spl_alw'];
                        $payroll_value['earned_spl_alw'] = $single_earned_spl_alw;
                        $single_spl_alw_arrear += $single_value['spl_alw_arrear'];
                        $payroll_value['arrear_spl_alw'] = $single_spl_alw_arrear;
                        $single_overtime += $single_value['overtime'];
                        $payroll_value['over_time'] = $single_overtime;
                        $single_total_earned_gross += $single_value['total_earned_gross'];
                        // $payroll_value['total_gross'] = $single_total_earned_gross;
                        // $single_pf_wages  +=   $single_value['pf_wages'];
                        // $payroll_value['pf_wages'] = $single_pf_wages;
                        // $single_pf_wages_arrear_epfr  +=  $single_value['pf_wages_arrear_epfr'];
                        $payroll_value['pf_wages_arrear'] = $single_pf_wages_arrear_epfr;
                        $single_epfr += $single_value['epfr'];
                        // $payroll_value['epfr'] = $single_epfr;
                        // $single_epfr_arrear  +=  $single_value['epfr_arrear'];
                        $payroll_value['epfr_arrear'] = $single_epfr_arrear;
                        $single_edli_charges += $single_value['edli_charges'];
                        // $payroll_value['edli_charges'] = $single_edli_charges;
                        // $single_edli_charges_arrears +=  $single_value['edli_charges_arrears'];
                        $payroll_value['edli_charges_arrears'] = $single_edli_charges_arrears;
                        $single_pf_admin_charges += $single_value['pf_admin_charges'];
                        // $payroll_value['pf_admin'] = $single_pf_admin_charges;
                        // $single_pf_admin_charges_arrears +=   $single_value['pf_admin_charges_arrears'];
                        $payroll_value['arrear_charges'] = $single_pf_admin_charges_arrears;
                        // $single_employer_esi  +=  $single_value['employer_esi'];
                        // $payroll_value['emp_esic'] = $single_employer_esi;
                        $single_employer_lwf += (int) ($single_value['employer_lwf']);
                        $payroll_value['lef'] = $single_employer_lwf;
                        // $single_ctc  +=  $single_value['ctc'];
                        // $payroll_value['ctc'] = $single_ctc;
                        // $single_epf_ee  +=  $single_value['epf_ee'];
                        // $payroll_value['epf_ee'] = $single_epf_ee;
                        // $single_epf_ee_arrear  +=  $single_value['epf_ee_arrear'];
                        // $payroll_value['epf_ee_arrear'] = $single_epf_ee_arrear;
                        // $single_employee_esic  +=  $single_value['employee_esic'];
                        // $payroll_value['employee_esic'] = $single_employee_esic;
                        // $single_prof_tax  +=  $single_value['prof_tax'];
                        // $payroll_value['prof_tax'] = $single_prof_tax;
                        // $single_income_tax  +=  $single_value['income_tax'];
                        // $payroll_value['income_tax'] = $single_prof_tax;
                        $single_sal_adv += $single_value['sal_adv'];
                        $payroll_value['sal_adv'] = $single_sal_adv;
                        $single_canteen_dedn += $single_value['canteen_dedn'];
                        $payroll_value['canteen_dedn'] = $single_canteen_dedn;
                        $single_other_deduc += $single_value['other_deduc'];
                        $payroll_value['otehr_dec'] = $single_other_deduc;
                        $single_lwf += $single_value['lwf'];
                        $payroll_value['lwf'] = $single_lwf;
                        $single_stats_bonus += $single_value['stats_bonus'];
                        $payroll_value['stats_bonus'] = $single_stats_bonus;
                        $single_earned_stats_bonus += $single_value['earned_stats_bonus'];
                        $payroll_value['earned_stats_bonus'] = $single_earned_stats_bonus;
                        $single_earned_stats_bonus_arrear += $single_value['earned_stats_arrear'];
                        $payroll_value['earned_stats_arrear'] = $single_earned_stats_bonus_arrear;
                        $single_travel_conveyence += $single_value['travel_conveyance'];
                        $payroll_value['travel_conveyence'] = $single_travel_conveyence;
                        $single_earned_stats_bonus += $single_value['other_earnings'];
                        $payroll_value['earned_stats_bonus'] = $single_earned_stats_bonus;


                        $actual[] = $single_value;
                    }
                }
            } else {

                foreach ($payslip_details as $key => $single_value) {
                    if ($single_value['payroll_months'] == $single_dates->format('Y-m-d')) {

                        // $single_basic1 += $single_value['basic'];
                        // $compensatory_value['Basic'] = $single_basic1;
                        // $single_hra1 += $single_value['hra'];
                        // $compensatory_value['Hra'] = $single_hra1;
                        $single_cld_all1 += $single_value['child_edu_allowance'];
                        $compensatory_value['Child_allowance'] = $single_cld_all1;
                        $single_spl_alw1 += $single_value['spl_alw'];
                        $compensatory_value['Special_allowance'] = $single_spl_alw1;
                        // $single_total_fixed_gross1  += $single_value['total_fixed_gross'];
                        // $compensatory_value['total_Fixed_Gross'] = $single_total_fixed_gross1;
                        $single_earned_basic1 += $single_value['earned_basic'];
                        $compensatory_value['Basic'] = $single_earned_basic1;
                        $single_basic_arrear1 += $single_value['basic_arrear'];
                        $compensatory_value['basic_arrear'] = $single_basic_arrear1;
                        $single_earned_hra1 += $single_value['earned_hra'];
                        $compensatory_value['Hra'] = $single_earned_hra1;
                        $single_hra_arrear1 += $single_value['hra_arrear'];
                        $compensatory_value['hra_arrear'] = $single_hra_arrear1;
                        $single_earned_child_edu_allowance1 += $single_value['earned_child_edu_allowance'];
                        $compensatory_value['earned_child_allowance'] = $single_earned_child_edu_allowance1;
                        $single_child_edu_allowance_arrear1 += $single_value['child_edu_allowance_arrear'];
                        $compensatory_value['children_allw_arrear'] = $single_child_edu_allowance_arrear1;
                        $single_earned_spl_alw1 += $single_value['earned_spl_alw'];
                        $compensatory_value['earned_spl_alw'] = $single_earned_spl_alw1;
                        $single_spl_alw_arrear1 += $single_value['spl_alw_arrear'];
                        $compensatory_value['arrear_spl_alw'] = $single_spl_alw_arrear1;
                        $single_overtime1 += $single_value['overtime'];
                        $compensatory_value['over_time'] = $single_overtime1;
                        // $single_total_earned_gross1  +=  $single_value['total_earned_gross'];
                        // $compensatory_value['total_gross'] = $single_total_earned_gross1;
                        // $single_pf_wages1  +=   $single_value['pf_wages'];
                        // $compensatory_value['pf_wages'] = $single_pf_wages1;
                        // $single_pf_wages_arrear_epfr1  +=  $single_value['pf_wages_arrear_epfr'];
                        // $compensatory_value['pf_wages_arrear'] = $single_pf_wages_arrear_epfr1;
                        // $single_epfr1  +=  $single_value['epfr'];
                        // $compensatory_value['epfr'] = $single_epfr1;
                        // $single_epfr_arrear1  +=  $single_value['epfr_arrear'];
                        // $compensatory_value['epfr_arrear'] = $single_epfr_arrear1;
                        // $single_edli_charges1  +=  $single_value['edli_charges'];
                        // $compensatory_value['edli_charges'] = $single_edli_charges1;
                        // $single_edli_charges_arrears1 +=  $single_value['edli_charges_arrears'];
                        // $compensatory_value['edli_charges_arrears'] = $single_edli_charges_arrears1;
                        // $single_pf_admin_charges1  +=  $single_value['pf_admin_charges'];
                        // $compensatory_value['pf_admin'] = $single_pf_admin_charges1;
                        // $single_pf_admin_charges_arrears1 +=   $single_value['pf_admin_charges_arrears'];
                        // $compensatory_value['arrear_charges'] = $single_pf_admin_charges_arrears1;
                        // $single_employer_esi1  +=  $single_value['employer_esi'];
                        // $compensatory_value['emp_esic'] = $single_employer_esi1;
                        // $single_employer_lwf1  +=  (int)($single_value['employer_lwf']);
                        // $compensatory_value['lef'] = $single_employer_lwf1;
                        // $single_ctc1  +=  $single_value['ctc'];
                        // $compensatory_value['ctc'] = $single_ctc1;
                        // $single_epf_ee1  +=  $single_value['epf_ee'];
                        // $compensatory_value['epf_ee'] = $single_epf_ee1;
                        // $single_epf_ee_arrear1  +=  $single_value['epf_ee_arrear'];
                        // $compensatory_value['epf_ee_arrear'] = $single_epf_ee_arrear1;
                        // $single_employee_esic1  +=  $single_value['employee_esic'];
                        // $compensatory_value['employee_esic'] = $single_employee_esic1;
                        // $single_prof_tax1  +=  $single_value['prof_tax'];
                        // $compensatory_value['prof_tax'] = $single_prof_tax1;
                        // $single_income_tax1  +=  $single_value['income_tax'];
                        // $compensatory_value['income_tax'] = $single_prof_tax1;
                        $single_sal_adv1 += $single_value['sal_adv'];
                        $compensatory_value['sal_adv'] = $single_sal_adv1;
                        $single_canteen_dedn1 += $single_value['canteen_dedn'];
                        $compensatory_value['canteen_dedn'] = $single_canteen_dedn1;
                        $single_other_deduc1 += $single_value['other_deduc'];
                        $compensatory_value['otehr_dec'] = $single_other_deduc1;
                        $single_lwf1 += $single_value['lwf'];
                        $compensatory_value['lwf'] = $single_lwf1;
                        $single_stats_bonus1 += $single_value['stats_bonus'];
                        $compensatory_value['stats_bonus'] = $single_stats_bonus1;
                        $single_earned_stats_bonus1 += $single_value['earned_stats_bonus'];
                        $compensatory_value['earned_stats_bonus'] = $single_earned_stats_bonus1;
                        $single_earned_stats_bonus_arrear1 += $single_value['earned_stats_arrear'];
                        $compensatory_value['earned_stats_arrear'] = $single_earned_stats_bonus_arrear1;
                        $single_travel_conveyence1 += $single_value['travel_conveyance'];
                        $compensatory_value['travel_conveyence'] = $single_travel_conveyence1;
                        $single_earned_stats_bonus1 += $single_value['other_earnings'];
                        $compensatory_value['earned_stats_bonus'] = $single_earned_stats_bonus1;


                        $projection[] = $single_value;
                    }
                }
            }
        }

        // dd($projection);

        foreach ($payroll_value as $key => $single_details) {
            if ($single_details == "0" || $single_details == null || $single_details == 0) {
                unset($payroll_value[$key]);
            }
        }

        foreach ($compensatory_value as $key => $single_details) {
            if ($single_details == "0" || $single_details == null) {
                unset($compensatory_value[$key]);
            }
        }

        $res = [];
        $res1 = [];
        foreach ($payroll_value as $key => $value) {
            if (isset($compensatory_value[$key])) {
                $res[$key] = $compensatory_value[$key] - $payroll_value[$key];
            } else {
                $res1[$key] = $payroll_value[$key];
            }
        }

        $total_income = 0;
        foreach ($res as $single_value) {
            $total_income += $single_value;
        }

        return ["Actual" => $payroll_value, "Projection" => $compensatory_value, "Total" => $res, "Total Income" => $total_income];
    }



    public function fetchInvestmentsReports($active_status, $regime_type)
    {

        $reports_data = array();

        if (empty($active_status)) {
            $active_status = ['1', '0', '-1'];
        } else {
            $active_status = $active_status;
        }

        if (empty($regime_type)) {
            $active_status = ['old', 'new'];
        } else {
            $regime_type = $regime_type;
        }

        $inv_emp = VmtInvFEmpAssigned::pluck('user_id')->toArray();

        $salary_data['headers'] = [];


        $Employee_details = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
            ->leftjoin('vmt_employee_statutory_details', 'vmt_employee_statutory_details.user_id', '=', 'users.id')
            ->where('users.active', $active_status)
            ->where('vmt_employee_statutory_details.tax_regime', $regime_type)
            //->where('users.client_id', $client_id)
            ->whereIn('users.id', $inv_emp)
            ->get(['users.id as user_id', 'users.user_code as Employee Code', 'users.name as Employee Name', 'vmt_employee_details.gender as Gender', 'vmt_employee_details.pan_number as PAN Number', 'vmt_employee_details.dob as Date Of Birth', 'vmt_employee_details.doj as Date Of Joining', 'vmt_employee_statutory_details.tax_regime as Tax Regime']);

        array_push($salary_data['headers'], "Employee Code", "Employee Name", "Gender", "PAN Number", "Date Of Birth", "Date Of Joining", "Tax Regime");

        $v_form_template = array();

        foreach ($Employee_details as $key => $single_user) {

            $employee_salary_details[$key]["Employee Code"] = $single_user['Employee Code'];
            $employee_salary_details[$key]["Employee Name"] = $single_user['Employee Name'];
            $employee_salary_details[$key]["Gender"] = $single_user['Gender'];
            $employee_salary_details[$key]["PAN Number"] = $single_user['PAN Number'];
            $employee_salary_details[$key]["Date Of Birth"] = $single_user['Date Of Birth'];
            $employee_salary_details[$key]["Date Of Joining"] = $single_user['Date Of Joining'];
            $employee_salary_details[$key]["Tax Regime"] = $single_user['Tax Regime'];

            $v_form_template[] = VmtInvFormSection::leftjoin('vmt_inv_section', 'vmt_inv_section.id', '=', 'vmt_inv_formsection.section_id')
                ->leftjoin('vmt_inv_section_group', 'vmt_inv_section_group.id', '=', 'vmt_inv_section.sectiongroup_id')
                ->leftjoin('vmt_inv_emp_formdata', 'vmt_inv_emp_formdata.fs_id', '=', 'vmt_inv_formsection.id')
                ->leftjoin('vmt_inv_f_emp_assigned', 'vmt_inv_f_emp_assigned.id', '=', 'vmt_inv_emp_formdata.f_emp_id')
                ->leftjoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'vmt_inv_f_emp_assigned.user_id')
                ->leftjoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'vmt_employee_compensatory_details.user_id')
                ->where('vmt_inv_f_emp_assigned.user_id', $single_user['user_id'])
                ->get(['vmt_inv_section_group.section_group', 'vmt_inv_section.particular', 'vmt_inv_section.max_amount', 'vmt_inv_emp_formdata.dec_amount', 'vmt_inv_emp_formdata.json_popups_value', 'vmt_employee_compensatory_details.gross', 'vmt_employee_compensatory_details.basic', 'vmt_inv_f_emp_assigned.regime', 'vmt_inv_f_emp_assigned.updated_at', 'vmt_employee_compensatory_details.hra', 'vmt_employee_compensatory_details.special_allowance', 'vmt_employee_compensatory_details.professional_tax', 'vmt_employee_compensatory_details.child_education_allowance', 'vmt_employee_compensatory_details.lta', 'vmt_employee_details.doj', 'vmt_employee_details.dob'])
                ->toArray();

        }

        $tax_reports_Section_column = array();

        foreach ($v_form_template as $form_key => $single_emp_form_data) {

            foreach ($single_emp_form_data as $key => $single_user_data) {

                if (!in_array($single_user_data['particular'], $tax_reports_Section_column)) {

                    array_push($tax_reports_Section_column, $single_user_data['particular']);
                    array_push($salary_data['headers'], $single_user_data['particular']);
                }

                $employee_salary_details[$form_key][$single_user_data['particular']] = $single_user_data['dec_amount'];
            }
        }

        foreach ($employee_salary_details as $section_key => $single_section_data) {

            foreach ($tax_reports_Section_column as $key => $single_section_column) {

                if (!in_array($single_section_column, array_keys($single_section_data))) {

                    $employee_salary_details[$section_key][$single_section_column] = 0;
                }
            }
        }

        $salary_data['rows'] = $employee_salary_details;

        $reports_data = $salary_data['headers'];

        $reports_data = $salary_data['rows'];

        //array_push($reports_data, array_unique($salary_data['headers']), $salary_data['rows']);


        return $reports_data;
    }


    public function generatePayslip(VmtAttendanceService $serviceVmtAttendanceService)
    {
        $user_code = "CT0003";
        $month = "09";
        $year = '2023';
        $type = 'pdf';
        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
                "year" => $year,
                "month" => $month,
                "type" => $type,

            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "year" => 'required',
                "month" => 'required',
                "type" => 'required',
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

            $user_data = User::where('user_code', $user_code)->first();
            $payroll_data = VmtPayroll::leftJoin('vmt_client_master', 'vmt_client_master.id', '=', 'vmt_payroll.client_id')
                ->leftJoin('vmt_emp_payroll', 'vmt_emp_payroll.payroll_id', '=', 'vmt_payroll.id')
                ->leftJoin('users', 'users.id', '=', 'vmt_emp_payroll.user_id')
                ->leftJoin('vmt_employee_payslip_v2', 'vmt_employee_payslip_v2.emp_payroll_id', '=', 'vmt_emp_payroll.id')
                ->leftJoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                ->leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->leftJoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'users.id')
                ->leftJoin('vmt_employee_statutory_details', 'vmt_employee_statutory_details.user_id', '=', 'users.id')
                ->leftJoin('vmt_department', 'vmt_department.id', '=', 'vmt_employee_office_details.department_id')
                ->leftJoin('vmt_banks', 'vmt_banks.id', '=', 'vmt_employee_details.bank_id')
                ->where('user_code', $user_code)
                ->whereYear('payroll_date', $year)
                ->whereMonth('payroll_date', $month);


            //get leave data
            $start_date = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d');

            $end_date = Carbon::create($year, $month)->lastOfMonth()->format('Y-m-d');

            $getleavedetails = $serviceVmtAttendanceService->leavetypeAndBalanceDetails($user_data->id, $start_date, $end_date, $month);

            $leave_data = array();

            foreach ($getleavedetails as $key => $single_leave_type) {

                if ($single_leave_type['leave_type'] <> "Sick Leave / Casual Leave" && $single_leave_type['leave_type'] <> "Earned Leave") {

                    if ($single_leave_type['availed'] != 0) {

                        array_push($leave_data, $single_leave_type);
                    }
                } else {
                    array_push($leave_data, $single_leave_type);
                }
            }

            $getpersonal['leave_data'] = $leave_data;


            // $financial_time   = VmtOrgTimePeriod::where('status','1')->first()->start_date;
            // $start_date =  Carbon::parse($financial_time );
            // $diff_months  = $start_date->diffInMonths(Carbon::now());

            // $months = [];
            // for($i=0; $i<$diff_months; $i++){
            //     $month = Carbon::parse($start_date)->addMonths($i)->format('Y-m-d');
            //     array_push($months,$month);
            // }

            // $months_details =[];
            // for($i=0; $i<count($months); $i++){
            // $vmt_payroll  =  VmtPayroll::join('vmt_emp_payroll','vmt_emp_payroll.payroll_id','=','vmt_payroll.id')
            //             ->join('vmt_employee_payslip_v2','vmt_employee_payslip_v2.emp_payroll_id','=','vmt_emp_payroll.id')
            //             ->where('vmt_emp_payroll.user_id',$user_data->id)
            //             ->where('payroll_date',$months[$i])
            //             ->get()->toArray();
            //             array_push($months_details,$vmt_payroll);
            // }

            $getpersonal['client_details'] = VmtClientMaster::where('id', $user_data->client_id)->get(
                [
                    'client_fullname',
                    'client_logo',
                    'address',
                ]
            )->toArray();


            $getpersonal['personal_details'] = $payroll_data
                ->get(
                    [
                        'users.name',
                        'users.user_code',
                        'vmt_employee_details.doj',
                        'vmt_department.name as department_name',
                        'vmt_employee_office_details.designation',
                        'vmt_employee_office_details.officical_mail',
                        'vmt_employee_details.pan_number',
                        'vmt_banks.bank_name',
                        'vmt_employee_details.bank_account_number',
                        'vmt_employee_details.bank_ifsc_code',
                        'vmt_employee_statutory_details.uan_number',
                        'vmt_employee_statutory_details.epf_number',
                        'vmt_department.name as department_name'
                    ]
                )->toArray();


            $getpersonal['salary_details'] = $payroll_data
                ->get(
                    [
                        'vmt_employee_payslip_v2.month_days',
                        'vmt_employee_payslip_v2.worked_Days',
                        'vmt_employee_payslip_v2.arrears_Days',
                        'vmt_employee_payslip_v2.lop',
                    ]
                )->toArray();

            $getearnings = $payroll_data
                ->get(
                    [
                        'vmt_employee_payslip_v2.basic as Basic',
                        'vmt_employee_payslip_v2.hra as HRA',
                        'vmt_employee_payslip_v2.earned_stats_bonus as Statuory Bonus',
                        'vmt_employee_payslip_v2.other_earnings as Other Earnings',
                        'vmt_employee_payslip_v2.earned_spl_alw as Special Allowance',
                        'vmt_employee_payslip_v2.travel_conveyance as Travel Conveyance ',
                        'vmt_employee_payslip_v2.earned_child_edu_allowance as Child Education Allowance',
                        'vmt_employee_payslip_v2.communication_allowance as Communication Allowance',
                        'vmt_employee_payslip_v2.food_allowance as Food Allowance',
                        'vmt_employee_payslip_v2.vehicle_reimbursement as Vehicle Reimbursement',
                        'vmt_employee_payslip_v2.driver_salary as Driver Salary',
                        'vmt_employee_payslip_v2.lta as Leave Travel Allowance',
                        'vmt_employee_payslip_v2.other_allowance as Other Allowance',
                        'vmt_employee_payslip_v2.overtime as Overtime',
                    ]
                )->toArray();


            $getarrears = $payroll_data
                ->get(
                    [
                        'vmt_employee_payslip_v2.basic_arrear as Basic',
                        'vmt_employee_payslip_v2.hra_arrear as HRA',
                        'vmt_employee_payslip_v2.earned_stats_bonus as Statuory Bonus',
                        'vmt_employee_payslip_v2.spl_alw_arrear  as Special Allowance',
                        'vmt_employee_payslip_v2.child_edu_allowance_arrear as Child Education Allowance',
                    ]
                )->toArray();
            //need  to add over_time arrears


            $getcontribution = $payroll_data
                ->get(
                    [
                        'vmt_employee_payslip_v2.epf_ee as EPF Employee',
                        'vmt_employee_payslip_v2.employee_esic as ESIC Employee ',
                        'vmt_employee_payslip_v2.vpf as VPF',
                    ]
                )->toArray();


            $gettaxdeduction = $payroll_data
                ->get(
                    [
                        'vmt_employee_payslip_v2.prof_tax as Professional Tax',
                        'vmt_employee_payslip_v2.lwf as LWF',
                        'vmt_employee_payslip_v2.income_tax as Income Tax',
                        'vmt_employee_payslip_v2.sal_adv as Salary Advance',
                        'vmt_employee_payslip_v2.canteen_dedn as Canteen Deduction',
                        'vmt_employee_payslip_v2.other_deduc as Other Deduction',
                    ]
                )->toArray();

            $getCompensatorydata = $payroll_data
                ->get(
                    [
                        'vmt_employee_compensatory_details.basic as Basic',
                        'vmt_employee_compensatory_details.hra as HRA',
                        'vmt_employee_compensatory_details.Statutory_bonus as Statuory Bonus',
                        'vmt_employee_compensatory_details.special_allowance as Special Allowance',
                        'vmt_employee_compensatory_details.child_education_allowance as Child Education Allowance',
                        'vmt_employee_compensatory_details.communication_allowance as Communication Allowance',
                        'vmt_employee_compensatory_details.food_allowance as Food Allowance',
                        'vmt_employee_compensatory_details.vehicle_reimbursement as Vehicle Reimbursement',
                        'vmt_employee_compensatory_details.driver_salary as Driver Salary',
                        'vmt_employee_compensatory_details.lta as Leave Travel Allowance',
                        'vmt_employee_compensatory_details.other_allowance as Other Allowance',
                    ]
                )->toArray();


            $getpersonal['date_month'] = [
                "Month" => DateTime::createFromFormat('!m', $month)->format('M'),
                "Year" => DateTime::createFromFormat('Y', $year)->format('Y'),
                "abs_logo" => '/assets/clients/ess/logos/AbsLogo1.png',
            ];

            // Total earnings

            $getpersonal['earnings'] = [];
            foreach ($getearnings as $single_payslip) {
                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }
                }
                array_push($getpersonal['earnings'], $single_payslip);
            }
            $getpersonal['arrears'] = [];
            foreach ($getarrears as $single_payslip) {
                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }
                }
                array_push($getpersonal['arrears'], $single_payslip);
            }

            if (!empty($getpersonal['earnings'])) {
                $total_value = 0;
                foreach ($getpersonal['earnings'][0] as $single_data) {
                    $total_value += ((int) $single_data);
                }
                $getpersonal['earnings'][0]['Total Earnings'] = $total_value;
            }

            // Total contribution

            $getpersonal['contribution'] = [];
            foreach ($getcontribution as $single_payslip) {
                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }
                }
                array_push($getpersonal['contribution'], $single_payslip);
            }

            if (!empty($getpersonal['contribution'])) {

                $total_value = 0;
                foreach ($getpersonal['contribution'][0] as $single_simma) {
                    $total_value += ((int) $single_simma);
                }
                $getpersonal['contribution'][0]['Total Contribution'] = $total_value;
            }

            // Total deduction

            $getpersonal['Tax_Deduction'] = [];
            foreach ($gettaxdeduction as $single_payslip) {
                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }
                }
                array_push($getpersonal['Tax_Deduction'], $single_payslip);
            }

            $getpersonal['compensatory_data'] = [];
            foreach ($getCompensatorydata as $single_payslip) {
                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }
                }
                array_push($getpersonal['compensatory_data'], $single_payslip);
            }

            if (!empty($getpersonal['Tax_Deduction'])) {

                $total_value = 0;
                foreach ($getpersonal['Tax_Deduction'][0] as $single_data) {
                    $total_value += ((int) $single_data);
                }
                $getpersonal['Tax_Deduction'][0]['Total Deduction'] = $total_value;
            }


            if (!empty($getpersonal['earnings']) && !empty($getpersonal['contribution']) && !empty($getpersonal['Tax_Deduction'])) {
                $total_amount = ($getpersonal['earnings'][0]['Total Earnings']) - ($getpersonal['contribution'][0]['Total Contribution']) - ($getpersonal['Tax_Deduction'][0]['Total Deduction']);

                $getpersonal['over_all'] = [
                    [
                        "Net Salary Payable" => $total_amount,
                        "Net Salary in words" => numberToWord($total_amount),
                    ]
                ];
            }


            $get_payslip = AbsActivePayslip::where('is_active', '1')->first();
            $status = "";
            $message = "";

            if ($type == "pdf") {

                $html = view('dynamic_payslip_templates.dynamic_payslip_template_pdf', $getpersonal);

                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isRemoteEnabled', true);

                $pdf = new Dompdf($options);
                $pdf->loadhtml($html, 'UTF-8');
                $pdf->setPaper('A4', 'portrait');
                $pdf->render();
                // $pdf->stream("payslip.pdf");

                $response['user_code'] = $user_code;
                $response['month'] = $month;
                $response['year'] = $year;
                $response['emp_name'] = $user_data->name;
                $pdf->stream(['payslip.pdf']);
                //$response['payslip'] = base64_encode($pdf->output(['payslip.pdf']));
            } elseif ($type == "html") {

                $html = view('dynamic_payslip_templates.dynamic_payslip_template_view', $getpersonal);

                $response = base64_encode($html);
            } else if ($type == "mail") {

                $html = view('dynamic_payslip_templates.dynamic_payslip_template_pdf', $getpersonal);

                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isRemoteEnabled', true);

                $pdf = new Dompdf($options);
                $pdf->loadhtml($html, 'UTF-8');
                $pdf->setPaper('A4', 'portrait');
                $pdf->render();

                $isSent = \Mail::to($getpersonal['personal_details'][0]['officical_mail'])
                    ->send(new PayslipMail(request()->getSchemeAndHttpHost(), $pdf->output(), $month, $year));

                if ($isSent) {
                    $status = "success";
                    $message = "Employee payslip send successfully";
                } else {
                    $status = "failure";
                    $message = "Error while send employee payslip";
                }
                return response()->json([
                    'status' => $status,
                    'message' => $message,
                    'data' => ''
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => "data fetch successfully",
                'data' => $response
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => "Error while fetch payslip details ",
                'data' => $e->getTraceAsString()
            ]);
        }
    }


    /*
        Testing : Used to check the mail speed.

    */
    public function checkMailSpeed(Request $request)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $request->user_code,
                "mail_content" => $request->mail_content,
                "can_queue" => $request->can_queue,
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "mail_content" => 'required',
                "can_queue" => 'required',
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
            dd($request->all());
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => "Error[ checkMailSpeed() ] ",
                'data' => $e->getTraceAsString()
            ]);
        }

    }

    /*
        Testing : To check the reports download speed.

    */
    public function checkReportsDownloadSpeed(Request $request)
    {

    }

    public function LeaveBalanceReport(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        if (empty($request->all())) {
            $org_time = VmtOrgTimePeriod::where('status', 1)->first();
        } else {
            $org_time = VmtOrgTimePeriod::where('id', $request->id)->first();
        }
        $start_date = $org_time->start_date;
        $end_date = $org_time->end_date;
        if (!empty($request->month)) {
            $end_date = Carbon::parse($request->month)->endOfMonth()->format('Y-m-d');
        }
        $month = Carbon::parse($org_time->end_date)->format('m');
        $year = Carbon::parse($org_time->end_date)->format('Y');


        $employees = $serviceVmtAttendanceService->fetchOrgLeaveBalance($start_date, $end_date, $month, $year);
        $leave_report = array();
        foreach ($employees as $single_employee) {
            $temp_ar = array();
            $leave_balance_details = $single_employee['leave_balance_details'][1];
            if(empty( $leave_balance_details)){
              dd($single_employee);
            }
            array_push($temp_ar, $single_employee['user_code'], $single_employee['name'], $leave_balance_details['leave_type'], $leave_balance_details['closing_balance']);
            array_push($leave_report, $temp_ar);
            unset($temp_ar);
        }
        return $leave_report;
    }
}
