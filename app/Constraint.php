<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Constraint
 *
 * @property-read Contest $contest
 * @property integer $id 
 * @property integer $contest_id 
 * @property string $key 
 * @property string $condition 
 * @property string $value 
 * @property boolean $optional 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\App\Constraint whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Constraint whereContestId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Constraint whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Constraint whereCondition($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Constraint whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Constraint whereOptional($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Constraint whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Constraint whereUpdatedAt($value)
 */
class Constraint extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key','condition','value','optional'];

    public function contest(){
        return $this->belongsTo(Contest::class);
    }



}
