<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VmtAnnouncementsService;

class VmtAnnouncementsController extends Controller
{
    public function createAnnouncementsDetails(Request $request, VmtAnnouncementsService $servicesVmtAnnouncementsService)
    {
        // dd($request->all());
        return $servicesVmtAnnouncementsService->createAnnouncementsDetails($request->user_id, $request->client_id, $request->announce_title, $request->announce_msg, $request->attach_img, $request->schedule_startdate, $request->start_time, $request->schedule_enddate, $request->end_time);
    }

    public function getAnnouncementsDetails(Request $request, VmtAnnouncementsService $servicesVmtAnnouncementsService)
    {
        return $servicesVmtAnnouncementsService->getAnnouncementsDetails($request->user_code);
    }

}
