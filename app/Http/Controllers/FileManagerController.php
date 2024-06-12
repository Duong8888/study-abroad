<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
    public function index()
    {
        $files = Storage::files('public/uploads/images');
        $files = array_map(function ($file) {
            return Storage::url($file);
        }, $files);
        return response()->json($files);
    }

//    public function upload(Request $request)
//    {
//        $request->validate([
//            'file' => 'required|image|max:2048',
//        ]);
//
//        $path = $request->file('file')->store('public/images');
//
//        return response()->json(['path' => Storage::url($path)]);
//    }

    public function destroy($fileName)
    {
        Storage::delete('public/uploads/images/' . $fileName);
        return response()->json(['success' => true, 'message' => 'Xóa thàng công.']);
    }
}
