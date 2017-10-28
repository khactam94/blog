<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Hash;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    const ACTIVE_STATUS = 1;
    const UNACTIVE_STATUS = 0;
    const BLOCK_STATUS = 2;

    protected $table = "users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'full_name', 'phone_number', 'birthday', 'address', 'active'
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
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }
    /**
     * default avatar
     * @param $input
     */
    public function getAvatarAttribute()
    {
        return $this->attributes['avatar'] != null ? $this->attributes['avatar'] : 'default.png';
    }
    public function getActiveAttribute()
    {
        $status = ['unactive', 'active', 'block'];
        return $status[$this->attributes['active']];
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', self::ACTIVE_STATUS);
    }

    public function addNew($input)
    {
        if(!empty($input['email'])){
            $user = static::where('email', $input['email'])->first();
            if($user != null){
                if($user->facebook_id == null){
                    $user->facebook_id = $input['facebook_id'];
                    $user->save();
                }
                return $user;
            }
        }
        $check = static::where('facebook_id',$input['facebook_id'])->first();
        if(is_null($check)){
            return static::create($input);
        }
        return $check;
    }
}