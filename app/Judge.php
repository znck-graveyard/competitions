<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Judge
 *
 * @property-read Contest $contest
 * @property integer $id 
 * @property integer $contest_id 
 * @property string $name 
 * @property string $email 
 * @property integer $user_id 
 * @property string $link 
 * @property string $judge_string 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\App\Judge whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Judge whereContestId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Judge whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Judge whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Judge whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Judge whereLink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Judge whereJudgeString($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Judge whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Judge whereUpdatedAt($value)
 */
class Judge extends Model {

	protected $table = 'judges';
	protected $fillable = ['name', 'email'];
	protected $guarded = ['id'];

	public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

}
