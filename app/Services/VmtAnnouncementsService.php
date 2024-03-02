<?php

namespace App\Services;

use App\Models\User;
use App\Models\VmtAnnouncementsTable;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class VmtAnnouncementsService
{

    public function createAnnouncementsDetails($user_id, $client_id, $announce_title, $announce_msg, $attach_img, $schedule_startdate, $start_time, $schedule_enddate, $end_time)
    {

        $validator = Validator::make(
            $data = [
                "user_id" => $user_id,
                "client_id" => $client_id,
                "announce_title" => $announce_title,
                "announce_msg" => $announce_msg,
                "attach_img" => $attach_img,
                "schedule_startdate" => $schedule_startdate,
                "start_time" => $start_time,
                "schedule_enddate" => $schedule_enddate,
                "end_time" => $end_time,
            ],
            $rules = [
                "user_id" => 'required',
                "client_id" => 'required',
                "announce_title" => 'required',
                "announce_msg" => 'required',
                "attach_img" => 'nullable',
                "schedule_startdate" => 'required',
                "start_time" => 'required',
                "schedule_enddate" => 'nullable',
                "end_time" => 'required',
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

        $user_details = User::where('id',$user_id)->first();
        $announce_details = VmtAnnouncementsTable::where('client_id',$user_details->client_id)->get();

        foreach($announce_details as $single_value){
              $start_date = Carbon::parse($single_value->schedule_startdate.' '.$single_value->start_time);
              $end_date = Carbon::parse($single_value->schedule_enddate.' '.$single_value->end_time);
              $input_Time = Carbon::parse($schedule_startdate .''. $start_time);
              if($input_Time->between($start_date,$end_date)){
                    return $response = [
                        'status' => 'success',
                        'data' => 'already allocated announcement in the time period'
                    ];
              }
        }
        $announcement = new VmtAnnouncementsTable;
        $announcement->author_id = $user_id;
        $announcement->client_id = $client_id;
        $announcement->announcement_title = $announce_title;
        $announcement->announcement_msg = $announce_msg;
        if ($attach_img) {
            $file_name = 'pic_' . $announce_title . '.' . $attach_img->extension();
            $path = 'Announcements';
            $attach_img->storeAs($path, $file_name, 'private1');
            $announcement->attach_img = $file_name;
        } else {
            $announcement->attach_img = '';
        }
        $announcement->schedule_startdate = Carbon::parse($schedule_startdate);
        $announcement->start_time = Carbon::parse($start_time);
        $announcement->schedule_enddate = $schedule_enddate == null || "" ? Carbon::parse($schedule_startdate) : Carbon::parse($schedule_enddate);
        $announcement->end_time = Carbon::parse($end_time);
        $announcement->save();

        return response()->json([
            'status' => 'success',
            'message' => "Announcement Created Successfully",
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'failure',
            'message' => 'Error in [createAnnouncementsDetails()]',
            'data' => $e->getMessage(),
            'error_verbose' => $e->getTraceAsString()
        ]);
    }

    }

    public function getAnnouncementsDetails($user_code)
    {
        $validator = Validator::make(
            $data = [
                "user_code" => $user_code
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
            $user_query = User::where('user_code', $user_code)->first();
            $announcement_detail = array();
            $client_id = $user_query->client_id;
            $announcement_details_query = VmtAnnouncementsTable::where('client_id', $user_query->client_id);
            if ($announcement_details_query->exists()) {
                $announcement_details_query = $announcement_details_query->get();
                foreach ($announcement_details_query as $single_details) {
                    $start_date = Carbon::parse($single_details->schedule_startdate . ' ' . $single_details->start_time);
                    $end_date = Carbon::parse($single_details->schedule_enddate . ' ' . $single_details->end_time);
                    if (Carbon::now()->between($start_date, $end_date)) {
                        $announcement_detail['id'] = $single_details->id;
                        $announcement_detail['author_id'] = $single_details->author_id;
                        $announcement_detail['client_id'] = $single_details->client_id;
                        $announcement_detail['announcement_title'] = $single_details->announcement_title;
                        $announcement_detail['announcement_msg'] = $single_details->announcement_msg;
                        if (Storage::disk('private1')->exists("Announcements/" . $single_details->attach_img)) {
                            $announcement_detail['image'] = base64_encode(Storage::disk('private1')->get("Announcements/" . $single_details->attach_img));
                        } else {
                            $announcement_detail['image'] = null;
                        }
                        break;
                    }
                }
                return response()->json([
                    'status' => 'success',
                    'message' => "Announcement Fetched Successfully",
                    'data' => $announcement_detail
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => "don't have any active Announcments"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error in [getAnnouncementsDetails()]',
                'data' => $e->getMessage(),
                'error_verbose' => $e->getTraceAsString()
            ]);
        }

    }

}
