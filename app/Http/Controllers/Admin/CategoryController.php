<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Http\Controllers\AppBaseController;
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
        if($request->has('q')){
            $categories = Category::where('name', 'like', '%'.$request->input('q').'%')->orderBy('id','DESC')->paginate(10);
        }
        else {
            $categories = Category::orderBy('id','DESC')->paginate(10);
        }

        return view('admin.categories.index')
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
        return view('admin.categories.create');
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $input = $request->all();

        $category = Category::create($input);
        Flash::success('Category saved successfully.');

        return redirect(route('categories.index'));
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

        return view('admin.categories.show')->with('category', $category);
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

        return view('admin.categories.edit')->with('category', $category);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param  int              $id
     * @param UpdateCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryRequest $request)
    {
        $category = Category::find($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }

        $category->update($request->all());
        Flash::success('Category updated successfully.');

        return redirect(route('categories.index'));
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
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }

        $category->delete();
        Flash::success('Category deleted successfully.');

        return redirect(route('categories.index'))->with('success', 'Category deleted successfully.');
    }
}
