<?php

namespace App\Http\Controllers;

use App\Content;
use App\ContentCategory;
use App\Http\Requests\StoreContent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        try {
            $contents = auth()->user()->contents()->with('content_category')->paginate(6);

            if ($request->ajax()) {
                return view('content.pagination-cards', compact('contents'))->render();
            }

            return view('content.index', compact('contents'));
        } catch (Exception $ex) {
            Log::error($ex->getMessage());

            return abort(500);
        }
    }

    /**
     * Display a listing of the favourite resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function favorites(Request $request)
    {
        try {
            $contents = auth()->user()->contents()->where('contents.favorite', '1')->with('content_category')->paginate(6);

            if ($request->ajax()) {
                return view('content.pagination-cards', compact('contents'))->render();
            }

            return view('content.favourites', compact('contents'));
        } catch (Exception $ex) {
            Log::error($ex->getMessage());

            return abort(500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            // get all content categories
            $content_categories = ContentCategory::all();

            return view('content.create', compact('content_categories'));
        } catch (Exception $ex) {
            Log::error($ex->getMessage());

            return abort(500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreContent  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContent $request)
    {
        try {
            $content = auth()->user()->contents()->create($request->all());

            if ($content) {

                return response()->json([
                    'status' => 'success',
                    'message' => 'Content stored successfully.',
                    'redirect_to' => route('contents.index')
                ]);
            } else {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to store.'
                ]);
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());

            return response()->json(['status' => 'error', 'message' => 'Server error.'], 500);
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
        try {

            // find user content by id
            $content = auth()->user()->contents()->find($id);

            // update content favorite column
            $content->favorite = ($content->favorite === '1' ? '0' : '1');
            $update = $content->save();

            if ($update) {

                return response()->json([
                    'status' => 'success',
                    'message' => ($content->favorite === '1' ? 'Content added to favourites.' : 'Content removed from favourites.')
                ]);
            } else {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to update.'
                ]);
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Server error.'
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $content)
    {
        try {
            // get all content categories
            $content_categories = ContentCategory::all();

            return view('content.create', compact('content_categories', 'content'));
        } catch (Exception $ex) {
            Log::error($ex->getMessage());

            return abort(500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreContent  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreContent $request, Content $content)
    {
        try {
            if ($content->update($request->all())) {

                return response()->json([
                    'status' => 'success',
                    'message' => 'Content stored successfully.',
                    'redirect_to' => route('contents.index')
                ]);
            } else {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to store.'
                ]);
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Server error.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content)
    {
        try {
            Storage::delete('public/files/' . $content->file_name);
            $content->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Content deleted successfully.'
            ]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Server error.'
            ], 500);
        }
    }
}
