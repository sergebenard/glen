<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Labour extends Model
{
	//
	protected $fillable = [
		'count',
		'name',
		'wage',
		'laborable_id',
		'laborable_type',
	];

	public function labourable()
	{
		return $this->morphTo();
	}


}
