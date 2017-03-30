<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagsPost extends Model
{
    public $fillable = [
        'post_id',
        'tag_id'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'post_id' => 'required',
        'tag_id' => 'required'
    ];
}
