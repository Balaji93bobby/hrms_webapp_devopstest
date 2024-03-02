<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\VmtClientMaster;
use App\Mail\WelcomeClientMail;
use Symfony\Component\Mailer\Exception\TransportException;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;
use App\Services\VmtClientService;

class VmtClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //    dd($request->all());
        $VmtClientMaster = VmtClientMaster::where('id', '1')->orderBy('created_at', 'DESC')->first();
        try {
            $vmtClient = new VmtClientMaster;
            $vmtClient->abs_client_code = $request->abs_client_code;
            $vmtClient->client_fullname = $request->client_full_name;
            $vmtClient->client_code = $request->client_code;
            $vmtClient->client_name = $request->client_name;
            $vmtClient->contract_start_date = $request->contract_start_date;
            $vmtClient->contract_end_date = $request->contract_end_date;
            $vmtClient->cin_number = $request->cin_number;
            $vmtClient->company_tan = $request->company_tan;
            $vmtClient->company_pan = $request->company_pan;
            $vmtClient->gst_no = $request->gst_no;
            $vmtClient->epf_reg_number = $request->epf_reg_number;
            $vmtClient->esic_reg_number = $request->esic_reg_number;
            $vmtClient->prof_tax_reg_number = $request->prof_tax_reg_number;
            $vmtClient->lwf_reg_number = $request->lwf_reg_number;
            $vmtClient->authorised_person_name = $request->authorised_person_name;
            $vmtClient->authorised_person_designation = $request->authorised_person_designation;
            $vmtClient->authorised_person_contact_number = $request->authorised_person_contact_number;
            $vmtClient->authorised_person_contact_email = $request->authorised_person_contact_email;
            $vmtClient->billing_address = $request->billing_address;
            $vmtClient->shipping_address = $request->shipping_address;
            if ($request->doc_uploads) {
                $docUploads = request()->file('doc_uploads');
                $docUploadsName = 'doc_' . time() . '.' . $docUploads->getClientOriginalExtension();
                $docUploadsPath = public_path('/images/');
                $docUploads->move($docUploadsPath, $docUploadsName);
                $docUploadpath = '/images/' . $docUploadsName;
            }
            if ($request->client_logo) {

                $file_path_exist = $request->client_full_name;

                $file = $request->file('client_logo');
                $fileName = $file->getClientOriginalName();
                $destinationPath = public_path() . '/assets/clients/' . $file_path_exist . '/logos/';
                $file->move($destinationPath, $fileName);
                $storepath = '/assets/clients/' . $file_path_exist . '/logos/' . $fileName;
            }
            $vmtClient->client_logo = $storepath;
            $vmtClient->doc_uploads = $docUploadpath;
            $vmtClient->product = $request->product;
            $vmtClient->subscription_type = $request->subscription_type;
            $vmtClient->save();

            $client_users = new User;
            $client_users->name = $request->authorised_person_name;
            $client_users->user_code = $request->authorised_person_contact_email;
            $client_users->client_id = $vmtClient->id;
            $client_users->email = $request->authorised_person_contact_email;
            $client_users->active = 1;
            $client_users->password = Hash::make('Abs@123123');
            $client_users->is_admin = 0;
            $client_users->is_onboarded = 1;
            $client_users->onboard_type = 'client_onboard';
            $client_users->is_default_password_updated = 0;
            $client_users->org_role = 2;
            $client_users->is_ssa = 0;
            $client_users->can_login = 1;
            $client_users->save();

            $image_view = url('/') . $VmtClientMaster->client_logo;

            \Mail::to($request->authorised_person_contact_email)->send(
                new WelcomeClientMail(
                    $request->client_name,
                    $request->authorised_person_contact_email,
                    'Abs@123123',
                    request()->getSchemeAndHttpHost(),
                    "",
                    $image_view,
                    $request->abs_client_code
                )
            );
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'client onboarded successfully.',
                ]
            );
        } catch (TransportException $e) {

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'client onboarded successfully.',
                    'mail_status' => 'failure',
                    'error' => $e->getMessage(),
                    'error_verbose' => $e
                ]
            );
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'failure',
                    'error' => $e->getMessage(),
                ]
            );
        }
    }

    public function showAllClients()
    {
        return view('vmt_client');
    }

    public function fetchAllClients(Request $request)
    {
        $user_query = User::where('user_code', $request->user_code)->first();
        if ($user_query->is_ssa == 1 || $user_query->org_role == 1 || $user_query->org_role == 2) {
            $all_clients = VmtClientMaster::get();
        } else {

            $all_clients = VmtClientMaster::where('client_id', $user_query->client_id)->get();
        }
        return response()->json($all_clients, 200);
    }

    public function getABSClientCode(Request $request, VmtClientService $serviceVmtClientService)
    {

        return $serviceVmtClientService->getABSClientCode($request->client_code);
    }
}
