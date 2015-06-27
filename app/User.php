<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 * App\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Contest[] $participatedContests
 * @property-read \Illuminate\Database\Eloquent\Collection|Entry[] $entriesSubmitted
 * @property-read \Illuminate\Database\Eloquent\Collection|Team[] $teams
 * @property-read \Illuminate\Database\Eloquent\Collection|UserAttribute[] $attributes
 * @property-read \Illuminate\Database\Eloquent\Collection|\Config::get('entrust.role[] $roles
 * @property integer $id 
 * @property string $username 
 * @property string $email 
 * @property string $first_name 
 * @property string $last_name 
 * @property string $gender 
 * @property string $password 
 * @property string $date_of_birth 
 * @property boolean $is_maintainer 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereDateOfBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereIsMaintainer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereDeletedAt($value)
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;
    use EntrustUserTrait;

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
    protected $fillable = ['username', 'first_name', 'email', 'password','is_maintainer'];

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
