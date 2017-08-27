<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Tag extends Model
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
        return $this->belongsToMany(Post::class, 'tags_posts');
    }

}
