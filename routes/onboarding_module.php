<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'onboarding'], function () {
    Route::get('/getAllDropdownFilters', [App\Http\Controllers\Api\VmtApiOnboardingController::class, 'getAllDropdownFilters']);
});
