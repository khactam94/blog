<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Category;
use Response;
use Flash;
use Illuminate\Support\Facades\DB;

class CategoryController extends AppBaseController
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the Category.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        return view('categories.index')
            ->with('categories', $categories);
    }

    public function search(Request $request)
    {
        if(config('database.default') =='pgsql'){
            $categories = Category::where('name', 'ilike', '%'.$request->input('query').'%')->paginate(10)->pluck('name');
        }
        elseif(config('database.default') =='mysql'){
            $categories = Category::where(DB::raw('upper(name)'), 'like', '%'.strtoupper($request->input('query')).'%')->limit(10)->pluck('name');
        }
        else{
            $categories = Category::where('name', 'like', '%'.$request->input('query').'%')->paginate(10)->pluck('name');
        }
        return json_encode($categories);
    }

    /**
     * Display the specified Category.
     *
     * @param  int $id
     find     * @return Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $posts = $category->posts;
        return view('categories.show')->with('posts', $posts);
    }
}
