<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Score
 *
 * @property integer $id
 * @property integer $judge_id
 * @property integer $contest_id
 * @property integer $entry_id
 * @property float $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Score whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Score whereJudgeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Score whereContestId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Score whereEntryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Score whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Score whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Score whereUpdatedAt($value)
 */
class Score extends Model {

	protected $table = 'scores';
	protected $fillable = ['value'];
	protected $guarded = ['id'];


}
