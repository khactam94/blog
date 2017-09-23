<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Support\Facades\Mail;

class HomeController extends AppBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
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
        $tags = Tag::paginate(25);
        $categories = Category::paginate(25);
        return view('home', compact('posts', 'tags', 'categories'));
    }
}
