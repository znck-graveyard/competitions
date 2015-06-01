<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviewer extends Model {

	protected $table = 'reviewers';
	protected $fillable = ['name', 'email','voted_at'];
	protected $guarded = ['id'];

}
