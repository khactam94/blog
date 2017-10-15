<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Http\Controllers\AppBaseController;
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
    public function oldIndex(Request $request)
    {
        $posts = $this->postRepository->getListPosts(25);
        return view('admin.posts.index',compact('posts'))
            ->with('i', ($request->input('page', 1) - 1) * 25);
    }
    public function index(Request $request)
    {
        return view('admin.posts.index');
    }

    public function datatable(){
        return $this->postRepository->getDatatable();
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
    public function store(StorePostRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $post = Post::create($input);
        $this->postRepository->saveCategories($post, $request->has('categories') ? $request->input('categories') : false);
        $this->postRepository->saveTags($post, $request->has('tags') ? $request->input('tags'): false);
        return redirect()->route('admin.posts.index')
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
        $post = Post::findOrFail($id);
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
        $post = Post::findOrFail($id);
        return view('admin.posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $status = $post->update($request->all());
        if(!$status) return back()->with('error', 'Update post failed.');
        $this->postRepository->saveCategories($post, $request->has('categories') ? $request->input('categories') : false);
        $this->postRepository->saveTags($post, $request->has('tags') ? $request->input('tags'): false);

        return redirect()->route('admin.posts.index')
            ->with('success','Post updated successfully');
    }

    public function approvePost($id){
        $post = Post::findOrFail($id);
        if($post == null) return response()->json(['message' => 'Not found your post', 'status' => false]);
        $post->status == 2;
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
        $post = Post::findOrFail($id);
        $post->removeTags();
        $post->removeCategories();
        $post->delete();
        return redirect()->route('admin.posts.index')
            ->with('success','Post deleted successfully');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        Post::whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Post deleted successfully."]);
    }
}
