<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
	public function myspackage()
	{
		return $this->belongsTo('App\Mypack');
	}
}
