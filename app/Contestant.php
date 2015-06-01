<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Contestant extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','contest_id'];



}
