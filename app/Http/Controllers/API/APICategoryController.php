<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Http\Controllers\AppBaseController;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Category;
use Response;
use Flash;

class APICategoryController extends AppBaseController
{
    /**
     * Remove the specified Category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return $this->sendResponse(['row' => 'cate_'.$id], 'Deleted post sucessfully!');
    }
}
