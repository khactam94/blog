<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMyPostRequest;
use App\Http\Requests\UpdateMyPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PostRepository;
use App\Http\Controllers\AppBaseController;

class MyPostController extends AppBaseController
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
        $posts = $request->has('q') ?
            $this->postRepository->searchPostsByAuthor(Auth::user()->id, $request->input('q'), 20)
        :   $this->postRepository->getPostsByAuthor(Auth::user()->id, 20);
        return view('my_posts.index',compact('posts'));
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
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $post = Post::create($input);
        $this->postRepository->saveCategories($post, $request->has('categories') ? $request->input('categories') : false);
        $this->postRepository->saveTags($post, $request->has('tags') ? $request->input('tags'): false);

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
        $post = $this->postRepository->getPostByAuthor($id, Auth::user()->id);
        if($post == null) abort(403);
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
        $post = $this->postRepository->getPostByAuthor($id, Auth::user()->id);
        if($post == null) abort(403);

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
        $post = $this->postRepository->getPostByAuthor($id, Auth::user()->id);
        if($post == null) abort(403);

        $status = $post->update($request->all());
        if(!$status) return back()->with('error', 'Update post failed.');
        $this->postRepository->saveCategories($post, $request->has('categories') ? $request->input('categories') : false);
        $this->postRepository->saveTags($post, $request->has('tags') ? $request->input('tags'): false);

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
        $post = $this->postRepository->getPostByAuthor($id, Auth::user()->id);
        if($post == null) abort(403);
        // Remove all tags, categories
        TagsPost::where('post_id', $post->id)->delete();
        CategoriesPost::where('post_id', $post->id)->delete();
        $post->delete();

        return redirect()->route('my_posts.index')
            ->with('success','Post deleted successfully');
    }
}
