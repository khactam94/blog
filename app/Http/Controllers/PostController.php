<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use App\Models\Post;
use App\Models\Category;
use App\Models\CategoriesPost;
use App\Models\Tag;
use App\Models\TagsPost;
use App\Models\User;

class PostController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recentlyPosts(Request $request)
    {
        $posts = Post::where('status', 2)->orderBy('id','DESC')->paginate(5);
        return view('posts.list',compact('posts'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::guest()) return back();
        $posts = Post::where('user_id', Auth::user()->id)->orderBy('id','DESC')->paginate(5);
        return view('posts.index',compact('posts'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guest()) return back();
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::guest()) return back();
        $this->validate($request, Post::$rules);
        $input =[];
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['view'] = 0;
        $input['status'] = 0;
        
        $post = Post::create($input);
        $categories = explode(', ', $input['categories']);
        $tags = explode(', ', $input['tags']);
        foreach ($categories as $category) {
            $category = Category::where('name', $category)->first();
            if($category == null) continue;
            CategoriesPost::create(['post_id' => $post->id, 'category_id' => $category->id]);
        }
        foreach ($tags as $tag) {
            $tag = Tag::where('name', $tag)->first();
            if($tag == null) continue;
            TagsPost::create(['post_id' => $post->id, 'tag_id' => $tag->id]);
        }
        return redirect()->route('my-posts.index')
            ->with('success','posts created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $post = Post::find($id);
        if($post == null) return back();
        //$post->increment('view');
        //$post->save();
        Event::fire('posts.view', $post);
        return view('posts.show',compact('post'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::guest()) return back();
        $post = Post::where('user_id', Auth::user()->id)->find($id);
        if($post == null) return back();
        return view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::guest()) return back();
        $post = Post::where('user_id', Auth::user()->id)->find($id);
        if($post == null) return back();
        return view('posts.edit',compact('post'));
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
        if (Auth::guest()) return back();
        $this->validate($request, Post::$rules);
        $input = $request->all();
        $status = Post::where('user_id', Auth::user()->id)->find($id)->update($input);
        if(!$status) return back()->with('error', 'Update post failed.'); 
        $post = Post::find($id);
        if($post == null) return back();
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
        return redirect()->route('my-posts.index')
            ->with('success','Post updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::guest()) return back();
        $post = Post::where('user_id', Auth::user()->id)->find($id);
        if($post == null) return back();
        foreach ($post->tags as $key => $tag) {
            TagsPost::where('tag_id', $tag->id)->where('post_id', $post->id)->delete();
        }
        foreach ($post->categories as $key => $category) {
            CategoriesPost::where('category_id', $category->id)->where('post_id', $post->id)->delete();
        }
        $post->delete();
        return redirect()->route('my-posts.index')
            ->with('success','Post deleted successfully');
    }
}
