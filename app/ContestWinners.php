<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContestWinners extends Model
{
    protected $fillable = [
        'contest_id',
        'position',
        'winnerable_id',
        'winnerable_type'
        ];

    /**
     * Polymorphic relation to determine winning users pr teams of a contest
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function winnerable()
    {
        return $this->morphTo();
    }
}
