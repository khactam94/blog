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
        $tags = Tag::paginate(100);
        return view('tags.index')
            ->with('tags', $tags);
    }

    public function search(Request $request)
    {
        if(config('database.default') =='pgsql'){
            $tags = Tag::where('name', 'ilike', '%'.$request->input('query').'%')->paginate(10)->pluck('name');
        }
        elseif(config('database.default') =='mysql'){
            $tags = Tag::where('UPPER(name)', 'like', '%'.strtoupper($request->input('query')).'%')->paginate(10)->pluck('name');
        }
        else{
            $tags = Tag::where('name', 'like', '%'.$request->input('query').'%')->paginate(10)->pluck('name');
        }
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
