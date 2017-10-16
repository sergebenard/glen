<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
	//
	public function materials()
	{
		return $this->morphMany('App\Materials', 'materialable');
	}
}