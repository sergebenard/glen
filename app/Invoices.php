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
		return $this->morphMany( Materials::class , 'materialable');
	}

	public function labour()
	{
		return $this->morphMany( Labour::class, 'labourable');
	}

	public function job()
	{
		return $this->belongsTo( Job::class );
	}

	public function togglePaid()
	{
		$this->paid = !$this->paid;

		return $this;
	}

	public function toggleSent()
	{
		$this->sent = !$this->sent;

		return $this;
	}
}
