<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class VmtEmployee extends Model
{
    use HasFactory;
    protected $table ="vmt_employee_details";

    //Dynamic attribute
    protected $appends = ['is_docs_approved','profile_completeness'];

    public function getUserDetail() {
        return $this->belongsTo(User::class);
    }

    //Called automatically
    protected function getIsDocsApprovedAttribute()
    {
        return isAllDocumentsApproved($this->user_id);

    }

    //Called automatically
    protected function getProfileCompletenessAttribute()
    {
        //Works only if this model is part of query joins.
        if(!empty($this->user_id))
            return calculateProfileCompleteness($this->user_id);
        else
            return "NA";

    }
}
