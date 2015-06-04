<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAttribute extends Model
{

    protected $fillable = ['user_id', 'key', 'value'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
