<?php

namespace App\Http\Controllers;

use App\Models\PostType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostsTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PostType::all();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'type_name' => 'required|string|max:255',
            ]);
            PostType::create($request->all());
            return response()->json(['success' => true, 'message' => 'Thêm mới thành công.']);
        }catch (\Exception $e) {
            Log::error('post_type: '. $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PostType $postType)
    {
        return response()->json($postType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validate([
                'type_name' => 'sometimes|required|string|max:255',
            ]);
            $postType = PostType::findOrFail($id);
            $postType->update($request->all());
            return response()->json(['success' => true, 'message' => 'Cập nhật thành công.']);
        }catch (\Exception $e) {
            Log::error('post_type: '. $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $postType = PostType::findOrFail($id);
            $postType->delete();
            return response()->json(['success' => true, 'message' => 'Xóa thành công.']);
        } catch (\Exception $e) {
            Log::error('post_type: '. $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
