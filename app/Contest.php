<?php namespace App;

use Illuminate\Database\Query\Builder;

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
 * @property \Carbon\Carbon                                             $start_date
 * @property \Carbon\Carbon                                             $end_date
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
 * @property string                                                     $contest_type
 * @property string                                                     $slug
 * @property boolean                                                    $public
 * @property string                                                     $prize_description
 * @property-read \Illuminate\Database\Eloquent\Collection|Entry[]      $entries
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereContestType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest wherePublic($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest wherePrizeDescription($value)
 * @property string                                                     $prize_1
 * @property string                                                     $prize_2
 * @property string                                                     $prize_3
 * @property string                                                     $admin_token
 * @property-read User                                                  $maintainer
 * @property-read mixed                                                 $start_time
 * @property-read mixed                                                 $end_time
 * @method static \Illuminate\Database\Query\Builder|\App\Contest wherePrize1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest wherePrize2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest wherePrize3($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereAdminToken($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|Team[]       $teams
 * @method static \Illuminate\Database\Query\Builder|\App\Contest published()
 * @property string                                                     $description_html
 * @property string                                                     $rules_html
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereDescriptionHtml($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contest whereRulesHtml($value)
 */
class Contest extends \Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'contest_type',
        'submission_type',
        'rules',
        'peer_review_enabled',
        'peer_review_weightage',
        'manual_review_enabled',
        'manual_review_weightage',
        'max_entries',
        'max_iteration',
        'team_entry_enabled',
        'team_size',
        'prize',
        'prize_1',
        'prize_2',
        'prize_3',
    ];

    protected $dates = ['start_date', 'end_date'];

    /**
     * A contest has many Constraints
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function constraints()
    {
        return $this->hasMany(Constraint::class);
    }

    public function maintainer()
    {
        return $this->belongsTo(User::class, 'maintainer_id');
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

    public function entries()
    {
        return $this->hasMany(Entry::class);
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
    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function scopePublished(Builder $query)
    {
        $query->where('public', true);
    }

    public function getStartTimeAttribute()
    {
        if ($this->start_date) {
            return $this->start_date->format('h:i a');
        }
    }

    public function setDescriptionAttribute($value)
    {
        $this->description_html = \Markdown::convertToHtml($value);

        $this->attributes['description'] = $value;
    }

    public function setRulesAttribute($value)
    {
        $this->rules_html = \Markdown::convertToHtml($value);

        $this->attributes['rules'] = $value;
    }

    public function getEndTimeAttribute()
    {
        if ($this->end_date) {
            return $this->end_date->format('h:i a');
        }
    }
}
