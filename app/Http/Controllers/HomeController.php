<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Category;
use App\Repositories\PostRepository;

class HomeController extends AppBaseController
{
    private $postRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PostRepository $postRepo)
    {
        $this->postRepository = $postRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $posts = $this->postRepository->searchPublicPost($request->q, 5);
        if ($request->ajax()) {
            $view = view('postdata',compact('posts'))->render();
            return response()->json(['html'=>$view]);
        }
        $tags = Tag::take(25)->get();
        $categories = Category::take(25)->get();
        return view('home', compact('posts', 'tags', 'categories'));
    }
}
