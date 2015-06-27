<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Contestant
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Entry[] $contestantEntries
 * @property integer $id 
 * @property integer $user_id 
 * @property integer $contest_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\App\Contestant whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contestant whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contestant whereContestId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contestant whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contestant whereUpdatedAt($value)
 */
class Contestant extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','contest_id'];

    /**
     * Contestant has submitted entries for a contest
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contestantEntries(){
        return $this->belongsToMany(Entry::class,"contestant_entry");
    }





}
