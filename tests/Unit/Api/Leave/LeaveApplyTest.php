<?php

use App\Models\User;

use Tests\TestCase;

uses(TestCase::class);

beforeEach(function(){

    $this->user_data = User::factory()->create();
   

    
});

it('can apply single day leave', function(){

    $singleleave_data = [
                    'user_code'                         =>"NAT0014",
                    'leave_request_date'                =>  '2023-09-20 15:15:02',
                    'leave_type_name'                   =>  'Sick Leave',
                    'leave_session'                     =>  '',
                    'start_date'                        =>  '2023-09-20',
                    'end_date'                          =>  '2023-09-20',
                    'no_of_days'                        =>  '1',
                    'hours_diff'                        =>  '',
                    'compensatory_work_days_ids'        =>  [],
                    'notify_to'                         =>  '',
                    'leave_reason'                      =>  'This is test reason',
                    'user_type'                         =>  'Employee'                    
                ];


    $response = $this->actingAs($this->user_data)->postJson('/api/attendance/apply_leave', $singleleave_data);

    $response->assertStatus(200)->assertJson([ 'status' => 'success']);

});


it('can apply half day leave', function(){

    $halfleave_data = [
                        "user_code"             => "NAT0014",
                        "leave_request_date"     =>  "2023-09-22  15:36:27",
                        "leave_type_name"       =>"Sick Leave",
                        "leave_session"         =>"FN",
                        "start_date"            =>"2023-09-05",
                        "end_date"              =>"2023-09-05",
                        "no_of_days"            =>0.5,
                        "hours_diff"            =>"",
                        "compensatory_work_days_ids"=>[],
                        "notify_to"             =>"",
                        "leave_reason"          =>"dsa",
                        "user_type"             =>"Employee"
                ];


    $response = $this->actingAs($this->user_data)->postJson('/api/attendance/apply_leave', $halfleave_data);
  
    $response->assertStatus(200)->assertJson([ 'status' => 'success']);

});


it('can apply custom day leave', function(){
    $customleave_data = [
                    "user_code"              =>  "NAT0014",
                    "leave_request_date"     =>"2023-09-21  16:37:06",
                    "leave_type_name"        =>"Earned Leave",
                    "leave_session"          =>"",
                    "start_date"             =>"2023-09-28",
                    "end_date"               =>"2023-09-30",
                    "no_of_days"             =>3,
                    "hours_diff"             =>"",
                    "compensatory_work_days_ids"=>[],
                    "notify_to"              =>"",
                    "leave_reason"           =>"sick",
                    "user_type"              =>"Employee"
    ];


         $response = $this->actingAs($this->user_data)->postJson('/api/attendance/apply_leave', $customleave_data);

            $response->assertStatus(200)->assertJson([ 'status' => 'success']);


        });

        it('already applied for given date singleday', function(){

            $singleleave_data = [
                'user_code'                         =>"NAT0014",
                'leave_request_date'                =>  '2023-09-20 15:15:02',
                'leave_type_name'                   =>  'Sick Leave',
                'leave_session'                     =>  '',
                'start_date'                        =>  '2023-09-20',
                'end_date'                          =>  '2023-09-20',
                'no_of_days'                        =>  '1',
                'hours_diff'                        =>  '',
                'compensatory_work_days_ids'        =>  [],
                'notify_to'                         =>  '',
                'leave_reason'                      =>  'This is test reason',
                'user_type'                         =>  'Employee'                    
            ];


            $response = $this->actingAs($this->user_data)->postJson('/api/attendance/apply_leave', $singleleave_data);


            expect($response['message'])->toEqual("Leave Request already applied for the given dates");


        });

        it('already applied for given date halfday', function(){

            $halfdayleave_data = [
                'user_code'                         =>"NAT0014",
                'leave_request_date'                =>  '2023-09-20 15:15:02',
                'leave_type_name'                   =>  'Sick Leave',
                'leave_session'                     =>  '',
                'start_date'                        =>  '2023-09-20',
                'end_date'                          =>  '2023-09-20',
                'no_of_days'                        =>  '1',
                'hours_diff'                        =>  '',
                'compensatory_work_days_ids'        =>  [],
                'notify_to'                         =>  '',
                'leave_reason'                      =>  'This is test reason',
                'user_type'                         =>  'Employee'                    
            ];


            $response = $this->actingAs($this->user_data)->postJson('/api/attendance/apply_leave', $halfdayleave_data);

            expect($response['message'])->toEqual("Leave Request already applied for the given dates");

        });

        it('
        already applied for given date singledaycustomleave', function(){
            $customleave_data = [
                            "user_code"              =>  "NAT0014",
                            "leave_request_date"     =>"2023-09-21  16:37:06",
                            "leave_type_name"        =>"Earned Leave",
                            "leave_session"          =>"",
                            "start_date"             =>"2023-09-28",
                            "end_date"               =>"2023-09-30",
                            "no_of_days"             =>3,
                            "hours_diff"             =>"",
                            "compensatory_work_days_ids"=>[],
                            "notify_to"              =>"",
                            "leave_reason"           =>"sssss",
                            "user_type"              =>"Employee"
            ];
        
        
                 $response = $this->actingAs($this->user_data)->postJson('/api/attendance/apply_leave', $customleave_data);
        
                 expect($response['message'])->toEqual("Leave Request already applied for the given dates");


                });

     it('fegt' ,function(){

        $users  = User::where('user_code','NAT0014')->first();
        $employee_details = VmtEmployee::where('userid',$users->id)->first();




     });







afterEach(function(){
    $this->user_data->delete();
    //$this->employee_office_details->delete();
});


