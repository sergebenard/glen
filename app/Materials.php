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

	public Function setNameAttribute( $value )
	{
		$this->attributes['name'] = ucwords( $value );
	}

	public Function setDescriptionAttribute( $value )
	{
		$this->attributes['description'] = ucwords( $value );
	}
}
