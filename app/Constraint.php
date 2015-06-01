<?php namespace App;

use Illuminate\Database\Eloquent\Model;

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
