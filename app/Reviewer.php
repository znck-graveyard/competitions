<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Reviewer
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Contest[] $contests
 * @property integer $id
 * @property integer $contest_id
 * @property integer $user_id
 * @property string $voted_at
 * @property integer $entry_id
 * @method static \Illuminate\Database\Query\Builder|\App\Reviewer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reviewer whereContestId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reviewer whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reviewer whereVotedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Reviewer whereEntryId($value)
 */
class Reviewer extends Model
{

    protected $table = 'reviewers';
    protected $fillable = ['voted_at'];
    protected $guarded = ['id'];
    public $timestamps = false;

    public function contests()
    {
        return $this->belongsTo(Contest::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
