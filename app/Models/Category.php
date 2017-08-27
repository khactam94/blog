<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
class Category extends Model
{
    public $fillable = [
        'name'
    ];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'categories_posts');
    }


}
