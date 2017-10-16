<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
	/*
	$table->string('number')->unique();
	$table->string('name');
	$table->string('address')->nullable();
	$table->bigInteger('phone')->nullable()->unsigned();
	$table->string('email')->nullable();
	$table->string('extension')->nullable();
	$table->text('note')->nullable();
	$table->boolean('finished')->default(0);
	*/

	protected $fillable = [
		'number',
		'name',
		'address',
		'phone',
		'email',
		'extension',
		'note',
		'finished'
	];

	//
	public function scopeUnfinished( $query )
	{
		return $query->where('finished', '<', 1);
	}

	public function scopeFinished( $query )
	{
		return $query->where('finished', '>', 0);
	}

	public function setPhoneAttribute( $value )
	{
		$phone = preg_replace("/[^0-9]/","", $value);
		$this->attributes['phone'] = ( empty( $phone ) ? null : $phone );
	}

	public Function setNameAttribute( $value )
	{
		$this->attributes['name'] = ucwords( $value );
	}

		/**
	 * Formats US and CA phone number formats
	 * @param  STRING $value Phone Number of Variable Length
	 * @return STRING        Phone number in pleasant visual format
	 */
	public function formatPhoneNumber( $value )
	{
		$length = strlen($value);
		switch($length)
		{
			case 7:
				return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $value);
				break;
			case 10:
				return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $value);
			break;
			case 11:
				return preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3-$4", $value);
			break;
			default:
				return $value;
			break;
		}
	}

}
