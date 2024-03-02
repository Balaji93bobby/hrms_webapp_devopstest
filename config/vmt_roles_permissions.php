<?php

use Illuminate\Support\Str;

return [
    'roles' => [
        "superadmin",
        "admin",
        "hr",
        "manager",
        "employee",
    ],
    'permissions' => [
        //SCREEN_NAME_operation
        'MANAGE_PAYSLIPS_can_view' => 'MANAGE_PAYSLIPS_can_view',
        'MANAGE_PAYSLIPS_release_payslip' => 'MANAGE_PAYSLIPS_release_payslip',

        'can_view_employees_payslip' => 'can_view_employees_payslip',

        'APPROVALS_can_view' => 'APPROVALS_can_view',

        'LEAVE_APPROVALS_can_approve_leaves' => 'LEAVE_APPROVALS_can_approve_leaves',
    ]
];
