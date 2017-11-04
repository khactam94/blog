<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Item
 * @package App\Models
 * @version September 24, 2017, 3:12 am UTC
 *
 * @property string name
 * @property string description
 */
class Subcriber extends Model
{
    use SoftDeletes;

    public $table = 'subcribers';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'email',
        'token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'email' => 'string',
        'token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'email' => 'required',
        'token' => 'required',
    ];


}