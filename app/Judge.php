<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Judge extends Model {

	protected $table = 'judges';
	protected $fillable = ['name', 'email'];
	protected $guarded = ['id'];

	public function contestants()
    {
        return $this->belongsToMany(Contest::class);
    }

}
