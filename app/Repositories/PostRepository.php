<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Carbon\Carbon;
use InfyOm\Generator\Common\BaseRepository;

class PostRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'content'
    ];
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Post::class;
    }

    public function getListPosts($perPage){
        return Post::orderBy('id','DESC')->paginate($perPage);
    }
    public function searchPublicPost($key, $perPage){
        if($key){
            $posts = Post::public()->search($key)
                ->with('categories')->with('tags')->orderBy('id','DESC')->paginate($perPage);
        }
        else{
            $posts = Post::public()->orderBy('id','DESC')->paginate($perPage);
        }
        return $posts;
    }
    public function getHotPosts($key, $perPage){
        if($key){
            $posts = Post::public()->where('created_at', '>=', Carbon::now()->subMonth())->search($key)
                ->with('categories')->with('tags')->orderBy('view','DESC')->paginate($perPage);
        }
        else{
            $posts = Post::public()->where('created_at', '>=', Carbon::now()->subMonth())
                ->orderBy('view','DESC')->paginate($perPage);
        }
        return $posts;
    }
    public function getPolularPosts($key, $perPage){
        if($key){
            $posts = Post::public()->search($key)
                ->with('categories')->with('tags')->orderBy('view','DESC')->paginate($perPage);
        }
        else{
            $posts = Post::public()->orderBy('view','DESC')->paginate($perPage);
        }
        return $posts;
        }
    public function getRelatedPosts(Post $post){
        $tagIds = $post->tags->pluck('id');
        $categoryIds = $post->categories->pluck('id');
        $postTags = Post::public()->whereIn('id', function ($query) use ($tagIds) {
            return $query->select('post_id')->from('tags_posts')->whereIn('tag_id', $tagIds);
        })->select('id', 'title', 'view')->limit(5)->get()->toArray();
        $postCategories = Post::public()->whereIn('id', function ($query) use ($categoryIds) {
            return $query->select('post_id')->from('categories_posts')->whereIn('category_id', $categoryIds);
        })->select('id', 'title', 'view')->limit(5)->get()->toArray();
        $posts = array_unique(array_merge($postTags, $postCategories), SORT_REGULAR);
        return $posts;
    }
    //My post controller
    public function searchPostsByAuthor($id, $key, $perPage){
        return Post::where('user_id', '=', $id)->search($key)
            ->with('categories')->with('tags')->orderBy('id','DESC')->paginate($perPage);
    }

    public function getPostsByAuthor($id, $perPage){
        return Post::where('user_id', '=', $id)->orderBy('id','DESC')->paginate($perPage);
    }
    public function getPostByAuthor($id, $userId){
        $post = Post::find($id);
        return $post->user_id == $userId ? $post : null;
    }
    //Home controller
    public function findPublicPost($id){
        $post = Post::public()->find($id);
        return $post;
    }
    //Home controller
    public function getStatusPosts($status){
        $id = array_search($status, Post::STATUSES);
        $posts = Post::where('status', $id)->paginate(10);
        return $posts;
    }
    //Import / Export data
    public function getPostsArray(){
        $fields = [
            'posts.title' => 'Title',
            'posts.content' => 'Content',
            'users.name' => 'Author',
            'status' => 'Status',
            'view' => 'View',
            'categories.name' => 'Category',
            'tags.name' => 'Tag',
            ];
        //DB::enableQueryLog();
        $posts = Post::export($fields)->get()->toArray();
        //dd(DB::getQueryLog());
        //dd($posts);
        return $posts;
    }

    public function getDatatable(){
        return \DataTables::of(Post::query()->select('id', 'title', 'content', 'user_id', 'status'))
            ->editColumn('content', function(Post $post) {
                return \Illuminate\Support\Str::words(strip_tags($post->content), 115, '...');
            })
            ->editColumn('user_id', function(Post $post) {
                return $post->user->name;
            })
            ->editColumn('status', function(Post $post) {
                return '<span class="label label-'.Post::STATUS_ITF[$post->status].'">'.Post::STATUSES[$post->status].'</span>';;
            })
            ->addColumn('action', function ($post) {
                //return $this->getActionButton($post->id);
                return view('admin.posts.datatables.action', compact('post'))->render();
            })
            ->addColumn('checkbox', function ($post) {
                return '<input type="checkbox" class="sub_chk" data-id="'.$post->id.'">';
            })
            ->rawColumns(['action', 'checkbox', 'status'])
            ->setRowId(function ($post) {
                return $post->id;
            })
            ->make(true);
    }
    //Post model
    public function saveCategories($post, $categoriesInput){
        if($categoriesInput){
            $categories = explode(',', $categoriesInput);
            $category_ids =[];
            foreach ($categories as $key => $value) {
                $category = Category::where('name', trim($value))->first();
                $category ? $category_ids[$key] = $category->id : null;
            }
            $post->categories()->sync($category_ids);
        }
    }
    public function saveTags($post, $tagsInput){
        if($tagsInput){
            $tags = explode(',', $tagsInput);
            $tag_ids = [];
            foreach ($tags as $key => $value) {
                $tag = Tag::where('name', $value)->first();
                $tag ? $tag_ids[$key] = $tag->id : null;
            }
            $post->tags()->sync($tag_ids);
        }
    }
}
