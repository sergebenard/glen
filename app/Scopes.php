<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scopes extends Model
{
    //
    protected $fillable = [
        'proposal_id',
        'description',
    ];


    /**
     * Scopes belongs to Proposals.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proposal()
    {
        // belongsTo(RelatedModel, foreignKey = proposals_id, keyOnRelatedModel = id)
        return $this->belongsTo(Proposals::class);
    }
}
