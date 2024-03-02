<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {

    //Creating new user. Here default password is "Abs@123123"
   $this->user_data = User::factory()->create();
});

it('can login on correct password', function() {
    // $user = User::factory()->create();

    // $login_data = ['user_code' => $this->user_data->user_code, 'password'=>'Abs@123123'];

    // $json_request = [
    //     "user_code" => $user_code,
    //     "password" => $password,
    // ];
    //dd($user->user_code);
    $login_data = ['user_code' => $this->user_data->user_code, 'password'=> 'Abs@123123'];
    //echo "Input data : ".json_encode($login_data);

    $response = $this->postJson('/api/auth/login', $login_data);
    $response->assertStatus(200)->assertJson([ 'status' => 'success']);
    //$this->assertDatabaseHas('posts', $post);
});

it('cannot login on wrong password', function() {

    $login_data = ['user_code' => $this->user_data->user_code, 'password'=> 'wrongpassword'];
    //echo "Input data : ".json_encode($login_data);


    $response = $this->postJson('/api/auth/login', $login_data);
    $response->assertStatus(401)->assertJson([ 'status' => 'failure']);

});



afterEach(function () {
    // Clean testing data after all tests run...
   $this->user_data->delete();

});
