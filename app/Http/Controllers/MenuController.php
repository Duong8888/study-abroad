<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::query()->orderBy('id','asc')->get();
        return response()->json($menus);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return a view to create a new menu item (if using blade templates)
        // return view('menus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
            ]);
            Menu::create($request->all());
            return response()->json(['success' => true, 'message' => 'Thêm mới thành công.']);
        }catch (\Exception $e) {
            Log::error('menu: '. $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return response()->json($menu->load('subMenus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        // Return a view to edit the menu item (if using blade templates)
        // return view('menus.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'sometimes|required|string|max:255',
            ]);
            $menu = Menu::query()->findOrFail($id);
            $menu->update($request->all());
            return response()->json(['success' => true, 'message' => 'Cập nhật thành công.']);
        }catch (\Exception $e) {
            Log::error('menu: '. $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Menu::query()->findOrFail($id);
            $data->delete();
            $childMenus = Menu::where('parent_id', $id)->get();
            foreach ($childMenus as $childMenu) {
                $this->destroy($childMenu->id);
            }
            return response()->json(['success' => true, 'message' => 'Xóa thành công.']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
