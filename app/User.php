<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'first_name', 'email', 'password', 'is_maintainer'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];
    protected $guarded = ['id'];


    /**
     * User can participate in many contest
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function participatedContests()
    {
        return $this->belongsToMany(Contest::class, "contestants");
    }

    /**
     * Entries Submitted by the User
     * Polymorphic relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function entriesSubmitted()
    {
        return $this->morphMany(Entry::class, 'entryable');
    }

    /**
     * Teams of which user is a member
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user');
    }


    /**
     * A user can have any no. of attributes
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes()
    {
        return $this->hasMany(UserAttribute::class);
    }
}
