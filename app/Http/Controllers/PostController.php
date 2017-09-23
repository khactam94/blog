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
            if(config('database.default') ==='pgsql'){
                $posts = Post::where('status', 2)->where('title', 'ilike', '%'.$request->q.'%')->orderBy('id','DESC')->paginate(25);
            }
            elseif(config('database.default') ==='mysql'){
                $posts = Post::where('status', 2)->where('UPPER(title)', 'ilike', '%'.strtoupper($request->q).'%')
                        ->orderBy('id','DESC')->paginate(25);
            }
            else{
                $posts = Post::where('status', 2)->where('title', 'ilike', '%'.$request->q.'%')
                        ->orderBy('id','DESC')->paginate(25);
            }
        }
        else {
            $posts = Post::where('status', 2)->orderBy('id','DESC')->paginate(25);
        }
        return view('posts.index',compact('posts'));
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
        if($post == null) return back();
        Event::fire('posts.view', $post);
        return view('posts.show',compact('post'));
    }
}
