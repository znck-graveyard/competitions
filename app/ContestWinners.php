<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ContestWinners
 *
 * @property integer $id 
 * @property integer $contest_id 
 * @property integer $position 
 * @property integer $winnerable_id 
 * @property string $winnerable_type 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \ $winnerable 
 * @method static \Illuminate\Database\Query\Builder|\App\ContestWinners whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ContestWinners whereContestId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ContestWinners wherePosition($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ContestWinners whereWinnerableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ContestWinners whereWinnerableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ContestWinners whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ContestWinners whereUpdatedAt($value)
 */
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
