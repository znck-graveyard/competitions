<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Contestant_Entry extends Model {

	protected $fillable=['entry_id','contestant_id','votes_count'];

}
