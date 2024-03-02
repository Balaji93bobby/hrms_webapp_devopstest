<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vmt_dashboard_posts extends Model
{
    use HasFactory;
     protected $table = 'vmt_dashboard_posts';

    protected $fillable = [
        "author_id",
        "message",
        "post_image",
     
    ];
}
