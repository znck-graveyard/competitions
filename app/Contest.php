<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =
        [
            'type',
            'name',
            'description',
            'submission_type',
            'rules',
            'peer_review_enabled',
            'peer_review_weightage',
            'manual_review_enabled',
            'manual_review_weightage',
            'max_entries',
            'max_iteration',
            'team_entry_enabled',
            'team_size'
        ];


    /**
     * A contest has many Constraints
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function constraints()
    {
        return $this->hasMany(Constraint::class);

    }


    /**
     * Many Users can participate in a contest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contestants()
    {
        return $this->belongsToMany(User::class, "contestants");
    }

    /**
     * Many submissions will be made for a contest
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissions()
    {
        return $this->hasMany(Entry::class);
    }


    /**
     *  Registered teams for a contest
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registeredTeams()
    {

        return $this->hasMany(Team::class);

    }

    protected $submission_type = ['pdf', 'mp3', 'mp4', 'png', 'jpeg', 'jpg'];
    public $type = [
        'PHOTOGRAPHY',
        'ART',
        'SINGING',
        'DANCE',
        'MUSIC',
        'SHORT FILMS',
        'CONTENT WRITING',
        'BUSINESS IDEA'];


    /**
     * @return array
     */
    public function getTypes()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getSubmissionTypes()
    {
        return $this->submission_type;
    }
}
