<?php

namespace App\Http\Controllers;

use App\Content;
use App\ContentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $contents = auth()->user()->contents()->with('content_category')->paginate(6);

        // if ajax request
        if ($request->ajax()) {
            return view('content.pagination-cards', compact('contents'))->render();
        }

        return view('content.index', compact('contents'));
    }

    /**
     * Display a listing of the favourite resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function favorites(Request $request)
    {
        $contents = auth()->user()->contents()->where('contents.favorite', '1')->with('content_category')->paginate(6);

        // if ajax request
        if ($request->ajax()) {
            return view('content.pagination-cards', compact('contents'))->render();
        }

        return view('content.index', compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $content_categories = ContentCategory::all();

        return view('content.create', compact('content_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_name' => 'string',
            'original_file_name' => 'string',
            'file_path' => 'required|string',
            'content_category_id' => 'required|integer',
        ], [
            'file_path.required' =>
            'File is required.',
            'content_category_id.required' => 'Please select a category.'
        ]);

        $user = auth()->user();

        $content = $user->contents()->create($request->all());
        if ($content) {
            return response()->json(['status' => 'success', 'message' => 'Content stored successfully.', 'redirect_to' => route('contents.index')]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to store.']);
        }
    }

    /**
     * Toggle favourite content by id
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleFavorite(Request $request, $id)
    {
        $user = auth()->user();

        $content = $user->contents()->find($id);

        $content->favorite = ($content->favorite === '1' ? '0' : '1');
        $update = $content->save();
        if ($update) {
            return response()->json(['status' => 'success', 'message' => ($content->favorite === '1' ? 'Content added to favourites.' : 'Content removed from favourites.')]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to update.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $content = auth()->user()->contents()->find($id);

        if (!$content) {
            return redirect('404');
        }

        $content_categories = ContentCategory::all();

        return view('content.create', compact('content_categories', 'content'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'file_name' => 'string',
            'original_file_name' => 'string',
            'file_path' => 'required|string',
            'content_category_id' => 'required|integer',
        ], [
            'file_path.required' => 'File is required.',
            'content_category_id.required' => 'Please select a category.'
        ]);

        $user = auth()->user();

        $content = $user->contents()->find($id);

        $update = $content->update($request->all());
        if ($update) {
            return response()->json(['status' => 'success', 'message' => 'Content stored successfully.', 'redirect_to' => route('contents.index')]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to store.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $content = auth()->user()->contents()->find($id);

        Storage::delete('public/files/' . $content->file_name);

        $content->delete();

        return response()->json(['status' => 'success', 'message' => 'Content deleted successfully.']);
    }
}
