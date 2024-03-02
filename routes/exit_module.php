<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'resignation'], function () {

    Route::get('/getResignationType', [App\Http\Controllers\VmtExitModuleController::class, 'getResignationType']);
    Route::post('/save-resignation-setting', [App\Http\Controllers\VmtExitModuleController::class, 'saveResignationSetting']);
    Route::get('/getClientlistForResignationSettings', [App\Http\Controllers\VmtExitModuleController::class, 'getClientlistForResignationSettings']);
    Route::post('/employeeResignationDetails', [App\Http\Controllers\VmtExitModuleController::class, 'employeeResignationDetails']);
    Route::post('/calculateLastWorkingDay',[App\Http\Controllers\VmtExitModuleController::class,'calculateLastWorkingDay']);
});
