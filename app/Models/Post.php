<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Tag;
use App\Models\Category;
class Post extends Model
{
    public $fillable = [
        'title',
        'content',
        'user_id',
        'status'
    ];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'content' => 'required',
        'categories' => 'required',
        'tags' => 'required'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function tags() {
        return $this->belongsToMany(Tag::class, 'tags_posts');
    }
    public function categories() {
        return $this->belongsToMany(Category::class, 'categories_posts');
    }
}
