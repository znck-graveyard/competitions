<?php namespace App;

use Illuminate\Database\Eloquent\Model;

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
