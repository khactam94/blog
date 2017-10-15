<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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

    /**
     * Set view
     * @param $input
     */
    public function setViewAttribute($input)
    {
        $this->attributes['view'] = $input ? $input : 0;
    }

    /**
     * Set view
     * @param $input
     */
    public function setUserIdAttribute($input)
    {
        $this->attributes['user_id'] = Auth::user()->id;
    }
    public function removeTags()
    {
        foreach ($this->tags as $key => $tag) {
            TagsPost::where('tag_id', $tag->id)->where('post_id', $this->id)->delete();
        }
    }
    public function removeCategories()
    {
        foreach ($this->categories as $key => $category) {
            CategoriesPost::where('category_id', $category->id)->where('post_id', $this->id)->delete();
        }
    }

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
