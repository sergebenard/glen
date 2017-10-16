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

	public function setPhoneAttribute($value)
	{
		$phone = preg_replace("/[^0-9]/","", $value);
		$this->attributes['phone'] = ( empty( $phone ) ? null : $phone );
	}
}
