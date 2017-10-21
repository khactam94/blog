<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;
use Excel;
use Carbon\Carbon;

class PostController extends AppBaseController
{
    private $postRepository;
    private $categoryRepository;
    private $tagRepository;
    private $userRepository;
    function __construct(PostRepository $postRepo, TagRepository $tagRepo, CategoryRepository $categoryRepo, UserRepository $userRepo)
    {
        $this->postRepository = $postRepo;
        $this->categoryRepository = $categoryRepo;
        $this->tagRepository = $tagRepo;
        $this->userRepository = $userRepo;
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

    /**
     * File Export Code
     *
     * @var array
     */
    public function export(Request $request)
    {
        $posts = $this->postRepository->getPostsArray();
        return Excel::create('post_list_'.Carbon::now()->format('dmY'), function($excel) use ($posts) {
            $excel->sheet('Posts', function($sheet) use ($posts)
            {
                $sheet->fromArray($posts, null, 'A1', true);
            });
        })->download('xlsx');
    }
    /**
     * Import file into database Code
     *
     * @var array
     */
    public function import(Request $request)
    {
        //dd($request);
        if($request->hasFile('excelFile')){
            try {
                $path = $request->file('excelFile')->getRealPath();
                $data = Excel::load($path, function ($reader) {
                })->get();
                //dd($data);
                if (!empty($data) && $data->count()) {
                    $date = \Carbon\Carbon::today()->format('Y-m-d');
                    foreach ($data->toArray() as $key => $value) {
                        if (!empty($value)) {
                            //Check title
                            $status = true;
                            if(!isset($value['title'])) continue;
                            $title = $value['title'];
                            $post = $this->postRepository->findByField('title', $title)->first();
                            if( $post != null) continue;
                            $post = [];
                            //Get content
                            $post['title'] = $value['title'];
                            $post['content'] = $value['content'];
                            $post['status'] = $value['status'];
                            $post['view'] = $value['view'];
                            $post['user_id'] = $this->userRepository->findForce($value['view'])->id;

                            $post['categories'] = [];
                            foreach (explode( ',', $value['category']) as $category){
                                array_push($post['categories'], $this->categoryRepository->findForce($category)->id);
                            };
                            $post['tags'] = [];
                            foreach (explode( ',', $value['tag']) as $tag){
                                array_push($post['tags'], $this->categoryRepository->findForce($tag)->id);
                            };
                            $insert[] = $post;
                        }
                    }
                    if (!empty($insert)) {
                        $posts = array();
                        foreach ($insert as $input) {
                            $post = Post::create($input);
                            //$post->tags()->sync($input['tags']);
                            //$post->categories()->sync($input['categories']);
                        }
                        return back()->with('success', 'Thêm thành công ' . count($insert) . ' cuốn sách.');
                    }else{
                        return back()->with('error','Dữ liệu không đúng!.');
                    }
                }
            }catch(\Exception $e){
                return back()->with('error','File sai định dạng.');
            }
        }
        return back()->with('error','Không tìm thấy file');
    }
}
