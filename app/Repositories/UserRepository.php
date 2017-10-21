<?php

namespace App\Repositories;

use App\Models\User;
use InfyOm\Generator\Common\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'password'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function findForce($name){
        $user = User::where('name', $name)->first();
        if($user == null) {
            $user = User::create(['name' => $name, 'email' => $name.'@gmail.com', 'password' => '123456']);
        }
        return $user;
    }
}
