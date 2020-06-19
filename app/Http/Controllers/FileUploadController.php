<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,mp4,mpga,pdf'
        ]);

        $file_name = time() . '.' . request()->file->getClientOriginalExtension();
        $original_file_name = request()->file->getClientOriginalName();
        request()->file->storeAs('files', $file_name, 'public');
        $file_path = Storage::url('files/' . $file_name);
        return response()->json(['data' => ['file_name' => $file_name, 'original_file_name' => $original_file_name, 'file_path' => $file_path], 'message' => 'File uploaded successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
