<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use App\Models\Post;
use App\Repositories\PostRepository;
class PostController extends AppBaseController
{
    private $postRepository;
    function __construct(PostRepository $postRepo)
    {
        $this->postRepository = $postRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = $this->postRepository->searchPublicPost($request->q, 20);
        return view('posts.index',compact('posts'));
    }

    public function hot(Request $request)
    {
        $posts = $this->postRepository->getHotPosts($request->q, 20);
        return view('posts.index',compact('posts'));
    }

    public function popular(Request $request)
    {
        $posts = $this->postRepository->getPolularPosts($request->q, 20);
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
        $post = $this->postRepository->findPublicPost($id);
        $post != null ? Event::fire('posts.view', $post) : abort(403);
        $previous = Post::public()->where('id', '<', $post->id)->orderBy('id', 'desc')->first();
        $next = Post::public()->where('id', '>', $post->id)->orderBy('id')->first();
        $relatedPosts = $this->postRepository->getRelatedPosts($post);
        $otherPosts = Post::public()->orderBy('id', 'desc')->limit(5)->get();
        return view('posts.show',compact('post', 'relatedPosts', 'next', 'previous', 'otherPosts'));
    }
}
