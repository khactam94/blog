<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Category;
use Response;
use Flash;
use App\Repositories\CategoryRepository;
class CategoryController extends AppBaseController
{
    private $categoryRepository;
    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
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
        $categories = $this->categoryRepository->search($request->input('query'));
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
