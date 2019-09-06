<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'user_id', 'jobTitle', 'jobDescription'
    ];
    public function recruiter()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
