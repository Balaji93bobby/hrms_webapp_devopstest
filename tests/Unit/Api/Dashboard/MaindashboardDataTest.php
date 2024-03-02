<?php

use App\Models\User;
use App\Models\VmtEmployeeOfficeDetails;

use Tests\TestCase;

uses(TestCase::class);

beforeEach(function(){

    $this->user_data = User::factory()->create();
    $this->employee_office_details = VmtEmployeeOfficeDetails::factory()->create([
        'user_id' => $this->user_data->id
    ]);

});

it('can fetch main dashboard data', function(){


    $user_code = [ 'user_code' => $this->user_data->user_code];
    $response = $this->actingAs($this->user_data)->postJson('/api/get-maindashboard-data', $user_code);
    //dd($response);
    $response->assertStatus(200)->assertJson([ 'status' => 'success']);
});

afterEach(function(){
    $this->user_data->delete();
    $this->employee_office_details->delete();
});
