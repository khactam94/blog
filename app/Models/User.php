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

    protected $table = "users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
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