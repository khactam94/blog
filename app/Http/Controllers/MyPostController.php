<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMyPostRequest;
use App\Http\Requests\UpdateMyPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\CategoriesPost;
use App\Models\TagsPost;
use App\Http\Controllers\AppBaseController;

class MyPostController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::where('user_id', '=', Auth::user()->id)->orderBy('id','DESC')->paginate(5);
        return view('my_posts.index',compact('posts'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('my_posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMyPostRequest $request)
    {
        $input =[];
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['view'] = 0;
        $input['status'] = 0;
        
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

        return redirect()->route('my_posts.index')
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
        $post = Post::where('user_id', '=', Auth::user()->id)->where('id', '=', $id)->first();
        
        if($post == null){
            return redirect()->route('my_posts.index')
            ->with('error','Posts not found');
        }
        
        return view('my_posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::where('id',$id)->where('user_id', Auth::user()->id)->first();

        if($post == null){
            return redirect()->route('my_posts.index')
            ->with('error','Posts not found');
        }

        return view('my_posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMyPostRequest $request, $id)
    {
        $post = Post::where('id',$id)->where('user_id', Auth::user()->id)->first();

        if($post == null){
            return redirect()->route('my_posts.index')
            ->with('error','Posts not found');
        }

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

        return redirect()->route('my_posts.index')
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
        $post = Post::where('id',$id)->where('user_id', Auth::user()->id)->first();

        if($post == null){
            return redirect()->route('my_posts.index')
            ->with('error','Posts not found');
        }

        // Remove all tags, categories
        TagsPost::where('post_id', $post->id)->delete();
        CategoriesPost::where('post_id', $post->id)->delete();
        $post->delete();

        return redirect()->route('my_posts.index')
            ->with('success','Post deleted successfully');
    }
}
