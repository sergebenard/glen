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
		'subtotal',
		'materialable_id',
		'materialable_type',
	];

	public function materialable()
	{
		return $this->morphTo();
	}

	public function setNameAttribute( $value )
	{
		$this->attributes['name'] = ucwords( $value );
	}

	public function setDescriptionAttribute( $value )
	{
		$this->attributes['description'] = ucwords( $value );
	}

	public function setSubtotalAttribute( $value )
	{
		if( $this->attributes['cost'] > 0 )
		{
			$this->attributes['subtotal'] = round( $this->attributes['cost'] * $this->attributes['count'], 2 );
		}
	}

	public function getCostAttribute( $value )
	{
		return ( !is_null( $value ) ) ? number_format($value, 2, '.', '') : $value;
	}

	public function getSubtotalAttribute( $value )
	{
		return ( !is_null( $value ) ) ? number_format($value, 2, '.', '') : $value;
	}
}
