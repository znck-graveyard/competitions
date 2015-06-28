<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Moderator
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Entry[] $verificationEntries
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $key
 * @property string $secret
 * @property integer $user_id
 * @property integer $contest_id
 * @property string $expiry
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Moderator whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Moderator whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Moderator whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Moderator whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Moderator whereSecret($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Moderator whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Moderator whereContestId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Moderator whereExpiry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Moderator whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Moderator whereUpdatedAt($value)
 */
class Moderator extends Model
{

    protected $table = 'moderators';
    protected $fillable = ['name', 'email', 'expiry'];
    protected $guarded = ['id', 'key', 'secret'];

    /**
     * Moderator verifies entries of a contest
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function verificationEntries()
    {
        return $this->belongsToMany(Entry::class,"moderator_contestant");
    }
}
