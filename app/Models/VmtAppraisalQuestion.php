<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VmtAppraisalQuestion extends Model
{
    use HasFactory;

    protected $table = 'vmt_performance_apraisal_questions';

    protected $fillable = [
        'dimension',
        'kpi',
        'operational_definition',
        'measure',
        'frequency',
        'target',
        'stretch_target',
        'source',
        'kpi_weightage',
        'author_id',
        'author_name',
    ];
}
