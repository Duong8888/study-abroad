<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            $data = $request->data;
            if (count($data) > 0) {
                foreach ($data as $value) {
                    if (isset($value['image'])) {
                        $file = $value['image'];
                        $path = $file->store('uploads/images', 'public');
                        $url = Storage::url($path);
                        Banner::create([
                            'title' => 'SMARTEDU',
                            'link' => $value['link'] ?? '',
                            'image_path' => $url,
                            'type' => $value['type'] ?? 0,
                        ]);
                    }else{
                        break;
                    }
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Thêm mới thành công.',
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => [
                    'message' => 'No file uploaded.'
                ]
            ], 400);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'error' => [
                    'message' => $e->getMessage()
                ]
            ], 400);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
