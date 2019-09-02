<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usercompany extends Model
{
    protected $fillable = [
        'user_id', 'company_id'
    ];
}
