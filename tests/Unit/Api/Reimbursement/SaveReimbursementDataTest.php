<?php
// use App\Models\VmtEmployeeReimbursements;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use App\Models\VmtReimbursements;
// use App\Models\User;
// use Carbon\Carbon;
// use Illuminate\Support\Facades\Log;

// beforeEach(function(){
//      //Creating new user. Here default password is "Abs@123123"
//    $this->user_data = User::factory()->create();
// });

// it('can login on correct password', function() {

//     $login_data = ['user_code' => $this->user_data->user_code, 'password'=> 'Abs@123123'];


//     $response = $this->postJson('/api/auth/login', $login_data);
//     $response->assertStatus(200)->assertJson([ 'status' => 'success']);

// });

// it('can save conveyance data',function(){
//     $local_conveyance_data=
//     [
//     'user_code'=>$this->user_data->id,
//     'date'=>Carbon::now()->format('Y-m-d'),
//     'reimbursement_type'=>'Local Conveyance',
//     'entry_mode'=>'',
//     'vehicle_type'=>'2-Wheeler',
//     'from'=>'home',
//     'to'=>'office',
//     'distance_travelled'=>50,
//     'user_comments'=>'Testing'

// ];
// Log::info( $this->user_data);
// $response = $this->postJson('/api/reimbursements/save_reimbursement_data',$local_conveyance_data);
// $response->assertStatus(200)->assertJson(['status'=>'sucess']);

// });
// afterEach(function () {
//     // Clean testing data after all tests run...
//    // VmtEmployeeReimbursements::where('user_id',$this->user_data->id)->whereDate('date','=',Carbon::now()->format('Y-m-d'))->delete();
//    $this->user_data->delete();

// });
