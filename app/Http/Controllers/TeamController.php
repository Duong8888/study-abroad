<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Team::all();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'name' => 'required',
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $file = $request->file('avatar');
            $path = $file->store('uploads/images', 'public');
            $avatarPath = Storage::url($path);
            $team = Team::create([
                'name' => $request->input('name'),
                'avatar' => $avatarPath,
            ]);

            return response()->json(['success' => true, 'message' => 'Team created successfully.', 'data' => $team]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to create team.','error'=>$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $team = Team::find($id);
        if ($team) {
            return response()->json(['success' => true, 'data' => $team]);
        } else {
            return response()->json(['success' => false, 'message' => 'Team not found.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $team = Team::query()->findOrFail($id);
            if (!$team) {
                return response()->json(['success' => false, 'message' => 'Team not found.'], 404);
            }
            $rule = '';
            if ($request->hasFile('avatar')) {
                $rule = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            };
            $validate = $request->validate([
                'name' => 'required',
                'avatar' => $rule,
            ]);

            if ($request->hasFile('avatar')) {
                if ($team->avatar) {
                    Storage::disk('public')->delete($team->avatar);
                }
                $file = $request->file('avatar');
                $path = $file->store('uploads/images', 'public');
                $avatarPath = Storage::url($path);
                $team->avatar = $avatarPath;
            }

            $team->name = $request->input('name');
            $team->save();

            return response()->json(['success' => true, 'message' => 'Team updated successfully.', 'data' => $team]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update team.','error'=>$e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $team = Team::query()->findOrFail(intval($id));
            if (!$team) {
                return response()->json(['success' => false, 'message' => 'Team not found.'], 404);
            }

            $team->delete();

            return response()->json(['success' => true, 'message' => 'Team deleted successfully.']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete team.'], 500);
        }
    }
}
