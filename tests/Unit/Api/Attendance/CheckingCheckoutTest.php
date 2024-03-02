<?php

use App\Models\User;

use Tests\TestCase;

uses(TestCase::class);

beforeEach(function(){

    $this->user_data = User::factory()->create();
    
});


it("Unable to check-out since Check-in is not done", function(){

    $checkout_data = [
        "user_code" => 'NAT0014',
        "existing_check_in_date" => date("Y-m-d"),
        "checkout_time" => date("h:i:s"),
        "work_mode" => 'office',
        "attendance_mode_checkout" => 'web',
        "checkin_lat_long" => '',
    ];


$response = $this->actingAs($this->user_data)->postJson('/api/attendance_checkout', $checkout_data);

expect($response['message'])->toEqual("Unable to check-out since Check-in is not done for the given date or Check-out is already done");

});


it("checkin", function(){

    $checkin_data = [
        "user_code" => 'NAT0014',
        "date" => date("Y-m-d"),
        "checkin_time" => date("h:i:s"),
        "selfie_checkin" => '' ,
        "work_mode" => 'office',
        "attendance_mode_checkin" => 'web',
        "checkin_lat_long" => '',

        
    ];


$response = $this->actingAs($this->user_data)->postJson('/api/attendance_checkin', $checkin_data);

$response->assertStatus(200)->assertJson([ 'status' => 'success']);

});

it("checkout", function(){

    $checkout_data = [
        "user_code" => 'NAT0014',
        "existing_check_in_date" => date("Y-m-d"),
        "checkout_time" => date("h:i:s"),
        "work_mode" => 'office',
        "attendance_mode_checkout" => 'web',
        "checkin_lat_long" => '',

        
    ];

    $response = $this->actingAs($this->user_data)->postJson('/api/attendance_checkout', $checkout_data);

    $response->assertStatus(200)->assertJson([ 'status' => 'success']);

});

it("checkin_while_checkedin ", function(){

    $already_checkedin_data = [

        "user_code" => 'NAT0014',
        "date" => date("Y-m-d"),
        "checkin_time" => date("h:i:s"),
        "selfie_checkin" => '' ,
        "work_mode" => 'office',
        "attendance_mode_checkin" => 'web',
        "checkin_lat_long" => '',
    ];

    
    $response = $this->actingAs($this->user_data)->postJson('/api/attendance_checkin', $already_checkedin_data);

    expect($response['message'])->toEqual("Check-in already done");
    






    
});

afterEach(function(){
    $this->user_data->delete();
    //$this->employee_office_details->delete();
});






















































?>
