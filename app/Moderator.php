<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Moderator extends Model {

	protected $table = 'moderators';
	protected $fillable = ['name', 'email','expiry'];
	protected $guarded = ['id','key','secret'];

}
