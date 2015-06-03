<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Moderator extends Model
{

    protected $table = 'moderators';
    protected $fillable = ['name', 'email', 'expiry'];
    protected $guarded = ['id', 'key', 'secret'];

    /**
     * Moderator verifies entries of a contest
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function verificationEntries()
    {
        return $this->belongsToMany(Entry::class,"moderator_contestant");
    }
}
