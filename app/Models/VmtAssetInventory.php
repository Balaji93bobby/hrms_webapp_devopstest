<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmtAssetInventory extends Model
{
    use HasFactory;
    protected $table ="vmt_asset_inventories";

    protected $fillable = [
        "asset_name", 
        "asset_type",
        "serial_number",
        "warranty",
        "vendor",
        "assignee",
        "assigned_date",
        "invoice",
        "asset_status"
    ];

}
