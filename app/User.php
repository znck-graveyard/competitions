<?php namespace App;

use Closure;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 * App\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Contest[]        $participatedContests
 * @property-read \Illuminate\Database\Eloquent\Collection|Entry[]          $entriesSubmitted
 * @property-read \Illuminate\Database\Eloquent\Collection|Team[]           $teams
 * @property-read \Illuminate\Database\Eloquent\Collection|UserAttribute[]  $attributes
 * @property-read \Illuminate\Database\Eloquent\Collection|\Config::get('entrust.role[] $roles
 * @property integer                                                        $id
 * @property string                                                         $username
 * @property string                                                         $email
 * @property string                                                         $first_name
 * @property string                                                         $last_name
 * @property string                                                         $gender
 * @property string                                                         $password
 * @property string                                                         $date_of_birth
 * @property boolean                                                        $is_maintainer
 * @property \Carbon\Carbon                                                 $created_at
 * @property \Carbon\Carbon                                                 $updated_at
 * @property string                                                         $deleted_at
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
 * @property-read \Illuminate\Database\Eloquent\Collection|Entry[]          $entries
 * @property-read mixed                                                     $name
 * @property string                                                         $remember_token
 * @property-read \Illuminate\Database\Eloquent\Collection|UserAttribute[]  $extras
 * @property mixed                                                          $profile_photo
 * @property mixed                                                          $cover_photo
 * @property mixed                                                          $connection_facebook
 * @property mixed                                                          $connection_twitter
 * @property mixed                                                          $connection_instagram
 * @property mixed                                                          $bio
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|Contest[]        $participating
 * @property-read \Illuminate\Database\Eloquent\Collection|Entry[]          $submissions
 * @property-read \Illuminate\Database\Eloquent\Collection|Contest[]        $maintaining
 * @property-read \Illuminate\Database\Eloquent\Collection|ContestWinners[] $wins
 * @property-read mixed                                                     $stat_submissions
 * @property-read mixed                                                     $stat_views
 * @property-read mixed                                                     $stat_upvotes
 * @property-read mixed                                                     $stat_wins
 * @property-read mixed                                                     $stat_creations
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

    protected $appended = [];
    protected $stats    = [];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden  = ['password'];
    protected $with    = ['extras'];
    protected $dates   = ['deleted_at', 'date_of_birth'];
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
        'profile_photo',
        'cover_photo',
    ];
    protected $appends = [
        'name',
        'profile_photo',
        'cover_photo',
        'connection_facebook',
        'connection_twitter',
        'connection_instagram',
        'bio',
    ];


    /**
     * User can participate in many contest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function participating()
    {
        return $this->belongsToMany(Contest::class, "contestants");
    }

    /**
     * Teams of which user is a member
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user');
    }


    /**
     * A user can have any no. of attributes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function extras()
    {
        return $this->hasMany(UserAttribute::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function submissions()
    {
        return $this->morphMany(Entry::class, 'entryable');
    }

    public function maintaining()
    {
        return $this->hasMany(Contest::class, 'maintainer_id');
    }

    public function voted()
    {
        return $this->hasManyThrough(Entry::class, Reviewer::class, 'user_id', 'entryable_id');
    }

    /**
     * Polymorphic relation to determine winning users of a contest
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function wins()
    {
        return $this->morphMany(ContestWinners::class, 'winnerable');
    }

    /*
     * Setters and Getters.
     */

    public function getUsernameAttribute($value)
    {
        if (!$value) {
            return $this->id;
        }

        return $value;
    }

    public function getNameAttribute()
    {
        return ucfirst($this->attributes['first_name'] . ' ' . $this->attributes['last_name']);
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst($value);
    }

    public function setProfilePhotoAttribute($value)
    {
        $this->storeAttribute('profile_photo', $value);
    }

    public function getProfilePhotoAttribute()
    {
        return $this->loadAttribute('profile_photo');
    }

    public function setCoverPhotoAttribute($value)
    {
        $this->storeAttribute('cover_photo', $value);
    }

    public function getCoverPhotoAttribute()
    {
        return $this->loadAttribute('cover_photo');
    }

    public function setConnectionFacebookAttribute($value)
    {
        if (!str_contains($value, 'facebook.com')) {
            $value = 'https://facebook.com/' . trim($value, ' /');
        }
        $this->storeAttribute('connection.facebook', $value);
    }

    public function getConnectionFacebookAttribute()
    {
        return $this->loadAttribute('connection.facebook');
    }

    public function setConnectionTwitterAttribute($value)
    {
        if (!str_contains($value, 'twitter.com')) {
            $value = 'https://twitter.com/' . trim($value, ' /');
        }
        $this->storeAttribute('connection.twitter', $value);
    }

    public function getConnectionTwitterAttribute()
    {
        return $this->loadAttribute('connection.twitter');
    }

    public function setConnectionInstagramAttribute($value)
    {
        if (!str_contains($value, 'instagram.com')) {
            $value = 'https://instagram.com/' . trim($value, ' /');
        }
        $this->storeAttribute('connection.instagram', $value);
    }

    public function getConnectionInstagramAttribute()
    {
        return $this->loadAttribute('connection.instagram');
    }

    public function setBioAttribute($value)
    {
        $this->storeAttribute('bio', $value);
    }

    public function getBioAttribute()
    {
        return $this->loadAttribute('bio');
    }

    public function getStatSubmissionsAttribute()
    {
        return $this->getStat('submissions', function () {
            return $this->submissions()->count();
        });
    }

    public function getStatViewsAttribute()
    {
        return $this->getStat('views', function () {
            return $this->submissions()->sum('views');
        });
    }

    public function getStatUpvotesAttribute()
    {
        return $this->getStat('upvotes', function () {
            return $this->submissions()->sum('upvotes');
        });
    }

    public function getStatWinsAttribute()
    {
        return $this->getStat('wins', function () {
            return $this->wins()->count();
        });
    }

    public function getStatCreationsAttribute()
    {
        return $this->getStat('creations', function () {
            return $this->maintaining()->count();
        });
    }

    public function getStat($key, Closure $callback)
    {
        if (!array_key_exists($key, $this->stats)) {
            $this->stats[$key] = $callback();
        }

        return $this->stats[$key];
    }

    public function imageUrl($width = null, $height = null)
    {
        return route('user.photo', [$this->username ?: $this->id, $width, $height]);
    }

    /**
     * @param $value
     * @param $key
     *
     * @return void
     */
    private function storeAttribute($key, $value)
    {
        UserAttribute::whereUserId($this->getKey())->whereKey($key)->delete();
        if ($value != null) {
            $this->extras()->create(compact('key', 'value'));
        }
    }

    private function loadAttribute($key, $force = false)
    {
        if ($force || empty($this->appended)) {
            foreach ($this->extras as $item) {
                $this->appended[$item->key] = $item->value;
            }
        }

        return array_get($this->appended, $key);
    }
}
