<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Judge extends Model {

	protected $table = 'judges';
	protected $fillable = ['name', 'email'];
	protected $guarded = ['id'];

	public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

}
