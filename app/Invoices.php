<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
	//
	protected $fillable = [
		'job_id',
		'sent',
		'paid',
	];

	public function materials()
	{
		return $this->morphMany('App\Materials', 'materialable');
	}

	public function labour()
	{
		return $this->morphMany('App\Labour', 'labourable');
	}

	public function job()
	{
		return $this->belongsTo( Job::class );
	}
}
