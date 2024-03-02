<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;

class VmtBankController extends Controller
{
    public function getBankDetails(){
        return Bank::all();
    }
}
