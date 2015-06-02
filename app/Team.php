<?php namespace App;

use Illuminate\Database\Eloquent\Model;

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

}
