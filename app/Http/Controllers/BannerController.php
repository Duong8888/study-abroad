<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Banner::query()->orderBy('id','DESC')->get();
        if (isset($request->type)) {
            $data = Banner::query()->where('type',intval($request->type))->get();
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
            $data = $request->data;
            if(!empty($data)){
                if (count($data) > 0) {
                    foreach ($data as $value) {
                        if (isset($value['id']) && $value['id']) {
                            // Update existing banner
                            $banner = Banner::find($value['id']);
                            if ($banner) {
                                if (isset($value['image'])) {
                                    $file = $value['image'];
                                    $path = $file->store('uploads/images', 'public');
                                    $url = Storage::url($path);
                                    $banner->image_path = $url;
                                }
                                $banner->link = $value['link'] ?? '';
                                $banner->type = $value['type'] ?? 0;
                                $banner->save();
                            }
                        } else {
                            // Create new banner
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
                            }
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Thêm mới/Cập nhật thành công.',
            ]);
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
    public function destroy(Request $request)
    {
        try {
            $ids = json_decode($request->ids);
            if (count($ids) > 0) {
//                $banners = Banner::find($ids);
//                foreach ($banners as $banner) {
//                    $imagePath = $banner->image_path;
//                    if (File::exists(public_path($imagePath))) {
//                        File::delete($imagePath);
//                    }
//                }
                Banner::destroy($ids);
                return response()->json(true);
            }
            return response()->json(false);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(false);
        }
    }

}
