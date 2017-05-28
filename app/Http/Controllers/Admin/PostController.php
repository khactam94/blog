<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        $this->validate($request, Post::$rules);
        $input =[];
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['view'] = 0;
        
        $post = Post::create($input);
        $categories = explode(', ', $input['categories']);
        $tags = explode(', ', $input['tags']);
        //dd($categories);
        foreach ($categories as $category) {
            $category = Category::where('name', $category)->get()[0];

            CategoriesPost::create(['post_id' => $post->id, 'category_id' => $category->id]);
        }
        foreach ($tags as $tag) {
            $tag = Tag::where('name', $tag)->get()[0];
            TagsPost::create(['post_id' => $post->id, 'tag_id' => $tag->id]);
        }
        return redirect()->route('posts.index')
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
        $post = Post::find($id);
        //$post->increment('view');
        //$post->save();
        Event::fire('admin.posts.view', $post);
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
        $post = Post::find($id);
        return view('admin.posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, Post::$rules);
        $input = $request->all();
        $status = Post::find($id)->update($input);
        if(!$status) return back()->with('error', 'Update post failed.'); 
        $post = Post::find($id);
        $categories = explode(', ', $input['categories']);
        $tags = explode(', ', $input['tags']);
        foreach ($categories as $key => $category) {
            $categories[$key] = Category::where('name', $category)->first()->id;
        }
        foreach ($tags as $key => $tag) {
            $tags[$key] = Tag::where('name', $tag)->first()->id;
        }
        if($request->has('categories')) {
            $post->categories()->sync($categories);
        }
        if($request->has('tags')) {
            $post->tags()->sync($tags);
        }
        return redirect()->route('posts.index')
            ->with('success','Post updated successfully');
    }

    public function approvePost($id){
        $post = Post::find($id);
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
        $post = Post::find($id);
        foreach ($post->tags as $key => $tag) {
            TagsPost::where('tag_id', $tag->id)->where('post_id', $post->id)->delete();
        }
        foreach ($post->categories as $key => $category) {
            CategoriesPost::where('category_id', $category->id)->where('post_id', $post->id)->delete();
        }
        $post->delete();
        return redirect()->route('posts.index')
            ->with('success','Post deleted successfully');
    }
}
