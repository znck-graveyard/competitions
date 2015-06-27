<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserAttribute
 *
 * @property-read User $user
 * @property integer $id 
 * @property integer $user_id 
 * @property string $key 
 * @property string $value 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\App\UserAttribute whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAttribute whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAttribute whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAttribute whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAttribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAttribute whereUpdatedAt($value)
 */
class UserAttribute extends Model
{

    protected $fillable = ['user_id', 'key', 'value'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
