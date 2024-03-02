<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compensatory extends Model
{
    use HasFactory;

    protected $table = 'vmt_employee_compensatory_details';

    protected $fillable = [
        "user_id",
        "basic",
        "hra",
        "Statutory_bonus",
        "child_education_allowance",
        "food_coupon",
        "lta",
        "special_allowance",
        "other_allowance",
        "gross",
        "epf_employer_contribution",
        "esic_employer_contribution",
        "insurance",
        "graduity",
        "cic",
        "epf_employee",
        "esic_employee",
        "professional_tax",
        "labour_welfare_fund",
        "net_income",
    ];
}
