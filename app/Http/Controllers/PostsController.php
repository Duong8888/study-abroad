<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Posts::query()->orderBy('id', 'desc')->get();
        if ($request->sort) {
            $sortIds = json_decode($request->sort, true);
            if (is_array($sortIds)) {
                $data = Posts::where(function($query) use ($sortIds) {
                    foreach ($sortIds as $sortId) {
                        $query->orWhereJsonContains('post_type_id', [['id' => $sortId]]);
                    }
                });
                if(isset($sortIds['limit'])){
                    $data->limit($sortIds['limit']);
                }
                $data = $data->get();
            } else {
                $data = Posts::whereJsonContains('post_type_id', [['id' => intval($request->sort)]])->get();
            }
        }
        if ($request->limit) {
            $data = Posts::query()->orderBy('id', 'desc')->limit(10)->get();
        }
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
            $validate = $request->validate([
                'title' => 'required',
                'content' => 'required',
                'slug' => 'required|unique:posts,slug',
                'thumbnail' => 'required',
                'category' => 'required',
                'description' => 'required',
                'type' => 'required',
            ],[
                'slug' => 'Slug này đã được sử dụng.'
            ]);

            Posts::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'slug' => $request->input('slug'),
                'thumbnail' => $request->input('thumbnail'),
                'description' => $request->input('description'),
                'author_id' => Auth::user()->id,
                'post_type_id' => json_encode($request->input('category')),
                'type' => $request->input('type'),
                'university_info' => $request->input('contentUniversity',null),
            ]);
            return response()->json(['success' => true, 'message' => 'Thêm mới thành công.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        try {
            $data = Posts::where('slug', $slug)->firstOrFail();
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        try {
            $data = Posts::where('slug', $slug)->firstOrFail();
            $validate = $request->validate([
                'title' => 'required',
                'content' => 'required',
                'slug' => [
                    'required',
                    Rule::unique('posts')->ignore($data->id,'id'),
                ],
                'category' => 'required',
                'description' => 'required',
                'type' => 'required',
            ],[
                'slug' => 'Slug này đã được sử dụng.'
            ]);
            $dataNew = [
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description'),
                'author_id' => Auth::user()->id,
                'post_type_id' => json_encode($request->input('category')),
                'type' => $request->input('type'),
                'university_info' => $request->input('contentUniversity',null),
            ];
            if ($request->input('thumbnail')) {
                $dataNew['thumbnail'] = $request->input('thumbnail');
            };
            $data->update($dataNew);
            return response()->json(['success' => true, 'message' => 'Cập nhật thành công.']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Posts::query()->findOrFail($id);
            $data->delete();
            return response()->json(['success' => true, 'message' => 'Xóa thành công.']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function uploadImage(Request $request): \Illuminate\Http\JsonResponse
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $path = $file->store('uploads/images', 'public');
            $url = Storage::url($path);

            return response()->json([
                'uploaded' => true,
                'url' => $url
            ]);
        }

        return response()->json([
            'uploaded' => false,
            'error' => [
                'message' => 'No file uploaded.'
            ]
        ], 400);
    }
}
