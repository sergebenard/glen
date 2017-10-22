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
		'subtotal',
		'laborable_id',
		'laborable_type',
	];

	public function labourable()
	{
		return $this->morphTo();
	}

	public function setNameAttribute( $value )
	{
		$this->attributes['name'] = ucwords( $value );
	}

	public function setSubtotalAttribute( $value )
	{
		if( $this->attributes['wage'] > 0 )
		{
			$this->attributes['subtotal'] = round( $this->attributes['wage'] * $this->attributes['count'], 2 );
		}
	}

	public function getWageAttribute( $value )
	{
		return ( !is_null( $value ) ) ? number_format($value, 2, '.', '') : $value;
	}

	public function getSubtotalAttribute( $value )
	{
		return ( !is_null( $value ) ) ? number_format($value, 2, '.', '') : $value;
	}

}
