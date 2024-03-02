<?php

dataset('correct_user_details', [
        ['name' => 'Praveen', 'user_code'=>'ABS001','email' =>'praveenkumar.techdev@gmail.com', 'password'=>'Abs@123123']
    ]
);

dataset('incorrect_user_details', [
        ['name' => 'Praveen', 'user_code'=>'','email' =>'praveenkumar.techdev@gmail.com', 'password'=>'wrong password'],
        ['name' => 'Praveen', 'user_code'=>'','email' =>'praveenkumar.techdev@gmail.com', 'password'=>'']
    ]
);
