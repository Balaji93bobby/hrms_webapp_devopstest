<?php

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

uses(TestCase::class);

it('can get App Base URL', function(string $client_code, string $expected_base_url){

    //Unable to access external URL via PEST. So using default Laravel API

    $response = Http::get('http://core.abshrms.com/api/getClientBaseURL?client_code='.$client_code);

    //$response = $this->getJson('http://core.abshrms.com/api/getClientBaseURL?client_code=dl2');
   // dd($response->json());
    expect($response->status())
            ->toBeInt()
            ->toBe(200);

    expect($response->json())
            ->toMatchArray([
                'status' => 'success',
                'data' => $expected_base_url
            ]);

   // $response->json()->assertJSON(['status'=>'success']);


})->with('base_url_dataset');
