<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Tag;
use Response;
use Flash;

class TagController extends AppBaseController
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the Tag.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $tags = Tag::orderBy('id','DESC')->paginate(10);

        return view('tags.index')
            ->with('tags', $tags);
    }

    public function search(Request $request)
    {
        $tags = Tag::where('name', 'like', '%'.$request->input('query').'%')->paginate(10)->pluck('name');

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
