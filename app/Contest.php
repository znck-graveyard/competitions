<?php namespace App;

/**
 * App\Contest
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Constraint[] $constraints
 * @property-read \Illuminate\Database\Eloquent\Collection|User[]       $contestants
 * @property-read \Illuminate\Database\Eloquent\Collection|Entry[]      $submissions
 * @property-read \Illuminate\Database\Eloquent\Collection|Team[]       $registeredTeams
 * @property integer                                                    $id
 * @property string                                                     $type
 * @property string                                                     $name
 * @property string                                                     $description
 * @property string                                                     $submission_type
 * @property string                                                     $image
 * @property string                                                     $rules
 * @property string                                                     $start_date
 * @property string                                                     $end_date
 * @property string                                                     $prize
 * @property boolean                                                    $peer_review_enabled
 * @property float                                                      $peer_review_weightage
 * @property boolean                                                    $manual_review_enabled
 * @property float                                                      $manual_review_weightage
 * @property integer                                                    $maintainer_id
 * @property integer                                                    $max_entries
 * @property integer                                                    $max_iteration
 * @property boolean                                                    $team_entry_enabled
 * @property integer                                                    $team_size
 * @property integer                                                    $page_view
 * @property \Carbon\Carbon                                             $created_at
 * @property \Carbon\Carbon                                             $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereSubmissionType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereRules($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereStartDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereEndDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest wherePrize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest wherePeerReviewEnabled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest wherePeerReviewWeightage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereManualReviewEnabled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereManualReviewWeightage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereMaintainerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereMaxEntries($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereMaxIteration($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereTeamEntryEnabled($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereTeamSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest wherePageView($value)
 */
class Contest extends \Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
     *
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
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissions()
    {
        return $this->hasMany(Entry::class);
    }


    /**
     *  Registered teams for a contest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registeredTeams()
    {

        return $this->hasMany(Team::class);

    }

    protected $submission_type = ['pdf', 'mp3', 'mp4', 'png', 'jpeg', 'jpg'];
    public    $type            = [
        'PHOTOGRAPHY',
        'ART',
        'SINGING',
        'DANCE',
        'MUSIC',
        'SHORT FILMS',
        'CONTENT WRITING',
        'BUSINESS IDEA'
    ];


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
