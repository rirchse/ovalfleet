<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public function User()
    {
    	return $this->hasMany('App\User');
    }
}
