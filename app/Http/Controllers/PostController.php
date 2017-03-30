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

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::orderBy('id','DESC')->paginate(5);
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
        Event::fire('posts.view', $post);
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
        $post = Post::find($id);
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
        $this->validate($request, Post::$rules);

        Post::find($id)->update($request->all());
        return redirect()->route('posts.index')
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
