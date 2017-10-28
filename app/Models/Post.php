<?php

namespace App\Models;

use App\Http\Controllers\Traits\ImportExportTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Nicolaslopezj\Searchable\SearchableTrait;
class Post extends Model
{

    use SearchableTrait;
    use ImportExportTrait;

    const PUBLIC_STATUS = 2;
    const DRAFT_STATUS = 0;
    const PRIVATE_STATUS = 1;

    public $fillable = [
        'title',
        'content',
        'user_id',
        'status'
    ];
    protected $relates = [
        'users' => ['users.id','posts.user_id'],
        'tags_posts' => ['tags_posts.post_id','posts.id'],
        'tags' => ['tags_posts.tag_id','tags.id'],
        'categories_posts' => ['categories_posts.post_id','posts.id'],
        'categories' => ['categories_posts.category_id','categories.id'],
    ];
    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'posts.title' => 10,
            'posts.content' => 8,
            'tags.name' => 5,
            'categories.name' => 5,
            'users.name' => 5,
        ],
        'joins' => [
            'users' => ['users.id','posts.user_id'],
            'tags_posts' => ['tags_posts.post_id','posts.id'],
            'tags' => ['tags_posts.tag_id','tags.id'],
            'categories_posts' => ['categories_posts.post_id','posts.id'],
            'categories' => ['categories_posts.category_id','categories.id'],
        ],
    ];

    /**
     * Validation rules
     *
     * @var array
     *
    public static $rules = [
        'title' => 'required',
        'content' => 'required',
        'categories' => 'required',
        'status' => 'required',
        'tags' => 'required'
    ];
    /**
     * Scope a query to only include public posts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublic($query)
    {
        return $query->where('status', self::PUBLIC_STATUS);
    }
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
