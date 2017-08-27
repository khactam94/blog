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
    public function index(Request $request)
    {
        if($request->has('q')){
            $posts = Post::where('status', 2)->where('title', 'like', '%'.$request->q.'%')->orderBy('id','DESC')->paginate(5);
        }
        else {
            $posts = Post::where('status', 2)->orderBy('id','DESC')->paginate(5);
        }
        return view('posts.index',compact('posts'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
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
}
