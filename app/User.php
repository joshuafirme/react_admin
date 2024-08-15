<?php


namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cache;
use App\Notifications\AllNotifications;
 
class User extends Model implements AuthenticatableContract, CanResetPasswordContract {
 
    use Notifiable,HasApiTokens, Authenticatable, CanResetPassword;
 
    protected $table = 'users';
    protected $fillable = ['username','role_id','agency_id','organization_id','profile_photo','api_token','firstname', 'middlename', 'lastname','phone_number', 'email', 'password','transaction_type','employee_no','qty_date_registered'];
    protected $hidden = ['password', 'remember_token'];
 
       // public $incrementing = false;
       // protected $primaryKey = 'name';
    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }
 
    public function setPasswordAttribute($password) {
        $this->attributes['password'] = bcrypt($password);
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsTo('App\Roles','id');
    }
    
    public function agencies()
    {
        return $this->hasOne('App\Agencies','id');
    }

    public function incidents()
    {
        return $this->hasMany('App\Incidents','id');
    }
    
    public function friends()
    {
      return $this->belongsToMany('App\User', 'friends', 'user_id_01', 'user_id_02')
        // if you want to rely on accepted field, then add this:
        ->wherePivot('action_user_id', '=', 1);
    }
    
    // friendship that I started
    public function friendsOfMine()
    {
      return $this->belongsToMany('App\User', 'friends', 'user_id_01', 'user_id_02')
         ->wherePivot('action_user_id', '=', 1) // to filter only accepted
         ->withPivot('action_user_id'); // or to fetch accepted value
    }
    
    // friendship that didn't accept yet
    public function pendingRequest()
    {
      return $this->belongsToMany('App\User', 'friends', 'user_id_02', 'user_id_01')
         ->wherePivot('action_user_id', '=', 0) // to filter only accepted
         ->withPivot('action_user_id'); // or to fetch accepted value
    }
    
     // friendship that didn't accept yet
    public function notYetAcceptFriend()
    {
      return $this->belongsToMany('App\User', 'friends', 'user_id_01', 'user_id_02')
         ->wherePivot('action_user_id', '=', 0) // to filter only accepted
         ->withPivot('action_user_id'); // or to fetch accepted value
    }

    // friendship that I was invited to 
    public function friendOf()
    {
      return $this->belongsToMany('App\User', 'friends', 'user_id_02', 'user_id_01')
         ->wherePivot('action_user_id', '=', 1)
         ->withPivot('action_user_id');
    }

    // accessor allowing you call $user->friends
    public function getFriendsAttribute()
    {
        if ( ! array_key_exists('friends', $this->relations)) $this->loadFriends();

        return $this->getRelation('friends');
    }

    protected function loadFriends()
    {
        if ( ! array_key_exists('friends', $this->relations))
        {
            $friends = $this->mergeFriends();

            $this->setRelation('friends', $friends);
        }
    }

    protected function mergeFriends()
    {
        return $this->friendsOfMine->merge($this->friendOf);
    }
    
    public function sendClientAddedNotification($client)
    {
        $this->notify(new AllNotifications($client));
    }
}
