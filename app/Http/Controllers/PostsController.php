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
            $data = Posts::whereJsonContains('post_type_id', [['id' => intval($request->sort)]])->get();
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
                'description' => 'required'
            ]);

            Posts::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'slug' => $request->input('slug'),
                'thumbnail' => $request->input('thumbnail'),
                'description' => $request->input('description'),
                'author_id' => Auth::user()->id,
                'post_type_id' => json_encode($request->input('category')),
            ]);
            return response()->json(['success' => true, 'message' => 'Create success.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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
                    Rule::unique('posts')->ignore($data->id),
                ],
                'category' => 'required',
                'description' => 'required'
            ]);
            $dataNew = [
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description'),
                'author_id' => Auth::user()->id,
                'post_type_id' => json_encode($request->input('category')),
            ];
            if ($request->input('thumbnail')) {
                $dataNew['thumbnail'] = $request->input('thumbnail');
            };
            $data->update($dataNew);
            return response()->json(['success' => true, 'message' => 'Update success.']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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
            return response()->json(['success' => true, 'message' => 'Delete success.']);
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
