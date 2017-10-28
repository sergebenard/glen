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

    /**
     * Proposals has many Scopes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scopes()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = proposals_id, localKey = id)
        return $this->hasMany(Scopes::class);
    }

    public function toggleSent()
    {
        $this->sent = !$this->sent;

        return $this;
    }
}
