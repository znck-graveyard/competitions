<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entry
 *
 * @property-read \                                                     $entryable
 * @property-read Contest                                               $contest
 * @property-read \Illuminate\Database\Eloquent\Collection|Moderator[]  $moderator
 * @property-read \Illuminate\Database\Eloquent\Collection|Contestant[] $owners
 * @property integer                                                    $id
 * @property string                                                     $abstract
 * @property string                                                     $filename
 * @property string                                                     $file_type
 * @property float                                                      $file_size
 * @property integer                                                    $contest_id
 * @property boolean                                                    $is_team_entry
 * @property integer                                                    $entryable_id
 * @property string                                                     $entryable_type
 * @property boolean                                                    $moderated
 * @property string                                                     $moderation_comment
 * @property \Carbon\Carbon                                             $created_at
 * @property \Carbon\Carbon                                             $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereAbstract($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereFileType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereContestId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereIsTeamEntry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereEntryableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereEntryableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereModerated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereModerationComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereUpdatedAt($value)
 * @property string                                                     $uuid
 * @property string                                                     $title
 * @property float                                                      $score
 * @property integer                                                    $upvotes
 * @property integer                                                    $downvotes
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereScore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereUpvotes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereDownvotes($value)
 * @property integer                                                    $views
 * @method static \Illuminate\Database\Query\Builder|\App\Entry whereViews($value)
 */
class Entry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abstract',
        'file_type',
        'file_size',
        'contest_id',
        'is_team_entry',
        'entryable_id',
        'entryable_type'
    ];

    protected $table = "entries";

    /**
     * A entry can be team entry or an individual entry
     * Polymorphic relation is used to specify its type
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function entryable()
    {
        return $this->morphTo();
    }

    /**
     * An Entry is submitted to a particular contest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function moderator()
    {
        return $this->belongsToMany(Moderator::class, 'moderator_contestant');
    }

    /**
     * Many contestants can own an entry
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function owners()
    {
        return $this->belongsToMany(Contestant::class, 'contestant_entry');
    }

    public function imageUrl($width = null, $height = null)
    {
        return route('contest.entry.photo', [$this->contest->slug, $this->uuid, $width, $height]);
    }
}
