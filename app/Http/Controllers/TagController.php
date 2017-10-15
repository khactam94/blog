<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\DB;
use App\Repositories\TagRepository;
use App\Models\Tag;
use Response;
use Flash;

class TagController extends AppBaseController
{
    private $tagRepository;
    public function __construct(TagRepository $tagRepo)
    {
        $this->tagRepository = $tagRepo;
    }

    /**
     * Display a listing of the Tag.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $tags = Tag::paginate(50);
        return view('tags.index')
            ->with('tags', $tags);
    }

    public function search(Request $request)
    {
        $tags = $this->tagRepository->search($request->input('q'));
        return json_encode($tags);
    }

    /**
     * Display the specified Tag.
     *
     * @param  int $id
     find     * @return Response
     */
    public function show($id)
    {
        $tag = Tag::findOrFail($id);
        $posts = $tag->posts;
        return view('tags.show')->with('posts', $posts);
    }
}
