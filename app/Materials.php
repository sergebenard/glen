<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materials extends Model
{
	//
	protected $fillable = [
		'name',
		'count',
		'description',
		'cost',
		'materialable_id',
		'materialable_type',
	];

	public function materialable()
	{
		return $this->morphTo();
	}
}
