<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        'status' => 'required',
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
