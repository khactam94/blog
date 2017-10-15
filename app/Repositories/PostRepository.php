<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
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
        Post::orderBy('id','DESC')->paginate($perPage);
    }

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
    private function getActionButton($id){
        return '<form method="POST" action="'.route('admin.posts.destroy', $id).'" accept-charset="UTF-8">'
            .'<input name="_method" type="hidden" value="DELETE">'
            .csrf_field()
            .'<div class="btn-group">'
            .'<a href="'.route("admin.posts.show", $id).'" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a> '
            .'<a href="'.route('admin.posts.edit', $id).'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'
            .'<button type="submit" class="btn btn-danger btn-xs"
                           data-tr="tr_'.$id.'"
                           data-toggle="confirmation"
                           data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-remove"
                           data-btn-ok-class="btn btn-sm btn-danger"
                           data-btn-cancel-label="Cancel"
                           data-btn-cancel-icon="fa fa-chevron-circle-left"
                           data-btn-cancel-class="btn btn-sm btn-default"
                           data-title="Are you sure you want to delete ?"
                           data-placement="left" data-singleton="true"><i class="glyphicon glyphicon-trash"></i></button>'
            .'</div>'
            .'</form>';
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
                return config('status.'.$post->status);
            })
            ->addColumn('action', function ($post) {
                return $this->getActionButton($post->id);
            })
            ->addColumn('checkbox', function ($post) {
                return '<input type="checkbox" class="sub_chk" data-id="'.$post->id.'">';
            })
            ->rawColumns(['action', 'checkbox'])
            ->setRowId(function ($post) {
                return $post->id;
            })
            ->make(true);
    }
}
