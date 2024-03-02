<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VmtNotificationsService;

class VmtApiNotificationsController extends Controller
{


    public function getNotifications(Request $request, VmtNotificationsService $serviceVmtNotificationsService){

        return $serviceVmtNotificationsService->getNotifications($request->user_code);

    }

    public function saveNotification(Request $request, VmtNotificationsService $serviceVmtNotificationsService){

        return $serviceVmtNotificationsService->saveNotification($request->user_code,
                                                                    $request->notification_title,
                                                                    $request->notification_body,
                                                                    $request->redirect_to_module,
                                                                    $request->recipient_user_code,
                                                                    $request->is_read,
                                                );

    }

    public function updateNotificationReadStatus(Request $request, VmtNotificationsService $serviceVmtNotificationsService){

        return $serviceVmtNotificationsService->updateNotificationReadStatus( recipient_user_code : $request->recipient_user_code,
                                                                              record_id : $request->record_id,
                                                                              read_status : $request->read_status
                                                                            );

    }
}
