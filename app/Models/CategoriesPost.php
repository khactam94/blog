<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriesPost extends Model
{
    public $fillable = [
        'post_id',
        'category_id'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'post_id' => 'required',
        'category_id' => 'required'
    ];
}
