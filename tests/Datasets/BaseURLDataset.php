<?php

dataset('base_url_dataset', function () {
    return [
        ["client_code"=>'dl2', 'expected_base_url'=>"https://demolivetwo.abshrms.com"],

        ["client_code"=>'ABS_CL1006', 'expected_base_url'=>"https://vasagroup.abshrms.com"],
        ["client_code"=>'ABS_CL1007', 'expected_base_url'=>"https://vasagroup.abshrms.com"],
        ["client_code"=>'ABS_CL1008', 'expected_base_url'=>"https://vasagroup.abshrms.com"],

        ["client_code"=>'ABS_CL1005', 'expected_base_url'=>"https://protocol.abshrms.com"],
        ["client_code"=>'ABS_CL1009', 'expected_base_url'=>"https://dunamis.abshrms.com"],

        ["client_code"=>'ABS_CL1010', 'expected_base_url'=>"https://breezetech.abshrms.com"],

        ["client_code"=>'ABS_CL1004', 'expected_base_url'=>"https://precede.abshrms.com"],
    ];
});

