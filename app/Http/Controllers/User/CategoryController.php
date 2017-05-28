<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Category;
use Response;
use Flash;

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
        $categories = Category::orderBy('id','DESC')->paginate(10);

        return view('categories.index')
            ->with('categories', $categories);
    }

    public function search(Request $request)
    {
        $categories = Category::where('name', 'like', '%'.$request->input('query').'%')->paginate(10)->pluck('name');

        return json_encode($categories);
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $category = Category::create($input);

        return redirect(route('categories.index'))
            ->with('success' , 'Category saved successfully.');
    }

    /**
     * Display the specified Category.
     *
     * @param  int $id
     find     * @return Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }

        return view('categories.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $category = Category::find($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }

        return view('categories.edit')->with('category', $category);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param  int              $id
     * @param UpdateCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $category = Category::find($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }

        $category->update($request->all());

        return redirect(route('categories.index'))->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (empty($category)) {
            return redirect(route('categories.index'))->with('error', 'Category not found');
        }

        $category->delete();

        return redirect(route('categories.index'))->with('success', 'Category deleted successfully.');
    }
}
