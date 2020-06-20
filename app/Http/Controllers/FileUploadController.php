<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
     * @param  App\Http\Requests\StoreFile  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFile $request)
    {
        try {
            // store file and get metadata
            $file_name = time() . '.' . $request->file('file')->getClientOriginalExtension();
            $original_file_name = $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('files', $file_name, 'public');
            $file_path = Storage::url('files/' . $file_name);

            return response()->json(['data' => ['file_name' => $file_name, 'original_file_name' => $original_file_name, 'file_path' => $file_path], 'message' => 'File uploaded successfully.']);
        } catch (Exception $ex) {
            // if exception occurred log error and return error json with 500 code
            Log::error($ex->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Server error.'], 500);
        }
    }
}
