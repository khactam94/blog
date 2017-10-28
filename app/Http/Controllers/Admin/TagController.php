<?php

namespace App\Http\Controllers\Admin;


use App\Models\TagsPost;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreTagRequest;
use App\Http\Requests\Admin\UpdateTagRequest;
use App\Http\Controllers\AppBaseController;
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

        return view('admin.tags.index')
            ->with('tags', $tags);
    }

    /**
     * Show the form for creating a new Tag.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created Tag in storage.
     *
     * @param CreateTagRequest $request
     *
     * @return Response
     */
    public function store(StoreTagRequest $request)
    {
        $tag = Tag::create($request->all());

        return redirect(route('admin.tags.index'))
            ->with('success' , 'Tag saved successfully.');
    }

    /**
     * Display the specified Tag.
     *
     * @param  int $id     
     * @return Response
     */
    public function show($id)
    {
        $tag = Tag::find($id);

        if (empty($tag)) {
            Flash::error('Tag not found');

            return redirect(route('admin.tags.index'));
        }

        return view('admin.tags.show')->with('tag', $tag);
    }

    /**
     * Show the form for editing the specified Tag.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tag = Tag::find($id);

        if (empty($tag)) {
            Flash::error('Tag not found');

            return redirect(route('admin.tags.index'));
        }

        return view('admin.tags.edit')->with('tag', $tag);
    }

    /**
     * Update the specified Tag in storage.
     *
     * @param  int              $id
     * @param UpdateTagRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTagRequest $request)
    {
        $tag = Tag::find($id);

        if (empty($tag)) {
            Flash::error('Tag not found');

            return redirect(route('admin.tags.index'));
        }

        $tag->update($request->all());

        return redirect(route('admin.tags.index'))->with('success', 'Tag updated successfully.');
    }

    /**
     * Remove the specified Tag from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        if (empty($tag)) {
            return redirect(route('admin.tags.index'))->with('error', 'Tag not found');
        }
        TagsPost::where('tag_id', $tag->id)->delete();
        $tag->delete();
        return redirect(route('admin.tags.index'))->with('success', 'Tag deleted successfully.');
    }
}
