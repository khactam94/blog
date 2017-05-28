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
     * Show the form for creating a new Tag.
     *
     * @return Response
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created Tag in storage.
     *
     * @param CreateTagRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $Tag = Tag::create($input);

        return redirect(route('tags.index'))
            ->with('success' , 'Tag saved successfully.');
    }

    /**
     * Display the specified Tag.
     *
     * @param  int $id
     find     * @return Response
     */
    public function show($id)
    {
        $Tag = Tag::find($id);

        if (empty($Tag)) {
            Flash::error('Tag not found');

            return redirect(route('tags.index'));
        }

        return view('tags.show')->with('Tag', $Tag);
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
        $Tag = Tag::find($id);

        if (empty($Tag)) {
            Flash::error('Tag not found');

            return redirect(route('tags.index'));
        }

        return view('tags.edit')->with('Tag', $Tag);
    }

    /**
     * Update the specified Tag in storage.
     *
     * @param  int              $id
     * @param UpdateTagRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $Tag = Tag::find($id);

        if (empty($Tag)) {
            Flash::error('Tag not found');

            return redirect(route('tags.index'));
        }

        $Tag->update($request->all());

        return redirect(route('tags.index'))->with('success', 'Tag updated successfully.');
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
        $Tag = Tag::find($id);

        if (empty($Tag)) {
            return redirect(route('tags.index'))->with('error', 'Tag not found');
        }

        $Tag->delete();

        return redirect(route('tags.index'))->with('success', 'Tag deleted successfully.');
    }
}
