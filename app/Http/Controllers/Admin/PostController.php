<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use App\Models\Post;
use App\Models\Category;
use App\Models\CategoriesPost;
use App\Models\Tag;
use App\Models\TagsPost;
use App\Http\Controllers\AppBaseController;

class PostController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::orderBy('id','DESC')->paginate(5);
        return view('admin.posts.index',compact('posts'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $input =[];
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['view'] = 0;
        
        $post = Post::create($input);
        if($request->has('categories')) {
            $categories = explode(',', $request->input('categories'));
            $category_ids =[];
            foreach ($categories as $key => $value) {
                $category = Category::where('name', trim($value))->first();
                $category ? $category_ids[$key] = $category->id : null;
            }
            $post->categories()->sync($category_ids);
        }
        if($request->has('tags')) {
            $tags = explode(',', $request->input('tags'));
            $tag_ids = [];
            foreach ($tags as $key => $value) {
                $tag = Tag::where('name', $value)->first();
                $tag ? $tag_ids[$key] = $tag->id : null;
            }
            $post->tags()->sync($tag_ids);
        }

        return redirect()->route('admin.posts.index')
            ->with('success','posts created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        
        return view('admin.posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $status = $post->update($request->all());
        if(!$status) return back()->with('error', 'Update post failed.'); 

        if($request->has('categories')) {
            $categories = explode(',', $request->input('categories'));
            $category_ids =[];
            foreach ($categories as $key => $value) {
                $category = Category::where('name', trim($value))->first();
                $category ? $category_ids[$key] = $category->id : null;
            }
            $post->categories()->sync($category_ids);
        }
        if($request->has('tags')) {
            $tags = explode(',', $request->input('tags'));
            $tag_ids = [];
            foreach ($tags as $key => $value) {
                $tag = Tag::where('name', $value)->first();
                $tag ? $tag_ids[$key] = $tag->id : null;
            }
            $post->tags()->sync($tag_ids);
        }

        return redirect()->route('admin.posts.index')
            ->with('success','Post updated successfully');
    }

    public function approvePost($id){
        $post = Post::findOrFail($id);
        if($post == null) return response()->json(['message' => 'Not found your post', 'status' => false]);
        $post->status ==2;
        $post->save();

        return response()->json([ 'post' => $post, 'message' => 'Updated successfully', 'status' => true]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        // Remove all tags
        foreach ($post->tags as $key => $tag) {
            TagsPost::where('tag_id', $tag->id)->where('post_id', $post->id)->delete();
        }
        // Remove all categories
        foreach ($post->categories as $key => $category) {
            CategoriesPost::where('category_id', $category->id)->where('post_id', $post->id)->delete();
        }
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success','Post deleted successfully');
    }
}
