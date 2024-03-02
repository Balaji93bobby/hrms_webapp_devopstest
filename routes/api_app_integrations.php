<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix'=>'payroll'], function () {

    Route::get('/app-integrations/getExternalAppsList', [App\Http\Controllers\VmtPayrollController::class, 'getExternalAppsList']);
    Route::post('/app-integrations/generateExternalApp_AccessToken', [App\Http\Controllers\VmtPayrollController::class, 'generateExternalApp_AccessToken']);

});


