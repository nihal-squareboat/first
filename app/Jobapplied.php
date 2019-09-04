<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobapplied extends Model
{
    protected $fillable = [
        'candidate_id', 'job_id',
    ];
}
