<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\OauthAccessToken;
use PhpParser\Builder;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'desc', 'roles'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function participantScore()
    {
        return $this->hasMany(ParticipantScore::class);
    }

    public function oauthAccessToken(){
        return $this->hasMany(OauthAccessToken::class);
    }


    ################# custom methods ###################

    public function generateToken()
    {
        return $this->createToken('DevConTallyApp')->accessToken;
    }

    public function hasRole($rolesToMatch)
    {
        $userRoles = explode(',', $this->roles);

        if (is_string($rolesToMatch)) {
            $rolesToMatch = explode(',', $rolesToMatch);
        }

        $matches = array_intersect($userRoles, $rolesToMatch);

        return count($matches) > 0;
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function scopeJudges($query){
        $query->where('roles', 'judge');
    }

    public function events(){
        return $this->belongsToMany(Event::class, 'event_judges');
    }
}
