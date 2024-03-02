<?php

namespace App\Services;

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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\vmtHolidays;


class VmtHolidayService
{


    public function getAllHolidays()
    {

        try {

            //Todo : Need to fetch holidays based on client_code

            $upcoming_holidays = vmtHolidays::where('holiday_date', '>', now())->orderBy('holiday_date', 'ASC')->get();
            $past_holidays = vmtHolidays::where('holiday_date', '<', now())->orderBy('holiday_date', 'ASC')->get();
            $master_holidays = $upcoming_holidays->merge($past_holidays);
            $i = 0;
            foreach ($master_holidays as $key => $Singleholiday) {

                $master_holidays[$i]['image'] = $this->getHolidaysPicture($Singleholiday->id);

                unset($master_holidays[$i]['id']);
                unset($master_holidays[$i]['created_at']);
                unset($master_holidays[$i]['updated_at']);
                unset($master_holidays[$i]['author_id']);
                unset($master_holidays[$i]['client_id']);
                $i++;
            }

            return response()->json([
                "status" => "success",
                "message" => "holidays fetch succcesfully",
                "data" => $master_holidays,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                "status" => "failure",
                "message" => "Unable to fetch holidays data",
                "data" => $e->getmessage(),
            ]);
        }
    }
    public function getHolidaysPicture($holiday_id)
    {
        //Validate
        $validator = Validator::make(
            $data = [
                'holiday_id' => $holiday_id,
            ],
            $rules = [
                'holiday_id' => 'required|exists:vmt_holidays,id',
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

            //Get the user record and update avatar column
            $holiday_image = vmtHolidays::where('id', $holiday_id)->first()->image;

            //Get the image from PRIVATE disk and send as BASE64
            $response = Storage::disk('private1')->get('/holidays/' . $holiday_image);

            if ($response) {

                $response =base64_encode($response);
            }
              return $response;

        } catch (\Exception $e) {

            //dd("Error :: uploadDocument() ".$e);

            return response()->json([
                "status" => "failure",
                "message" => "Unable to fetch profile picture",
                "data" => $e,
            ]);
        }
    }
}
