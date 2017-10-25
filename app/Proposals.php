<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposals extends Model
{
    protected $fillable = [
        'job_id',
        'sent',
        'status',
    ];
    //
    public function materials()
    {
    	return $this->morphMany( Materials::class, 'materialable');
    }

    public function labour()
    {
    	return $this->morphMany( Labour::class, 'labourable');
    }
    public function job()
    {
    	return $this->belongsTo( Job::class );
    }

    public function toggleSent()
    {
        $this->sent = !$this->sent;

        return $this;
    }
}
