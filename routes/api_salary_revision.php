<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix'=>'salary_revision'], function () {

    Route::get('getAllEmployeeData', [App\Http\Controllers\VmtSalaryRevisionController::class, 'getAllEmployeeData']);


});
