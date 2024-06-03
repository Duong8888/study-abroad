<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = University::all();
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
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $file = $request->file('logo');
            $path = $file->store('uploads/images', 'public');
            $logoPath = Storage::url($path);
            $team = University::create([
                'university_name' => $request->input('name'),
                'logo' => $logoPath,
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
        $team = University::find($id);
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
            $team = University::query()->findOrFail($id);
            if (!$team) {
                return response()->json(['success' => false, 'message' => 'Team not found.'], 404);
            }
            $rule = '';
            if ($request->hasFile('logo')) {
                $rule = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            };
            $validate = $request->validate([
                'name' => 'required',
                'logo' => $rule,
            ]);

            if ($request->hasFile('logo')) {
                if ($team->logo) {
                    Storage::disk('public')->delete($team->logo);
                }
                $file = $request->file('logo');
                $path = $file->store('uploads/images', 'public');
                $logoPath = Storage::url($path);
                $team->logo = $logoPath;
            }

            $team->university_name = $request->input('name');
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
            $team = University::query()->findOrFail(intval($id));
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
