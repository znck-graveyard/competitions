<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Entry;

/**
 * App\Team
 *
 * @property-read Contest $contestName
 * @property-read \Illuminate\Database\Eloquent\Collection|Entry[] $entriesSubmitted
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $teamMembers
 * @property integer $id
 * @property string $name
 * @property integer $contest_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereContestId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Team whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|ContestWinners[] $winnerTeam 
 */
class Team extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'contest_id'];

    /**
     * returns the contest name for which team is registered
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contestName()
    {
        return $this->belongsTo(Contest::class);
    }

    /**
     * Entries submitted by the Team
     * Polymorphic Relation
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function entriesSubmitted()
    {
        return $this->morphMany(Entry::class, 'entryable');
    }

    /**
     * team members of a team
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teamMembers()
    {
        return $this->belongsToMany(User::class, 'team_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function winnerTeam()
    {
        return $this->morphMany(ContestWinners::class, 'winnerable');
    }

}
