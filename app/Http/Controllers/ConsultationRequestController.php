<?php

namespace App\Http\Controllers;

use App\Models\ConsultationRequest;
use Illuminate\Http\Request;

class ConsultationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ConsultationRequest::query()->orderBy('created_at', 'desc')->get();
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
        $validated = $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required',
            'email' => 'email',
        ]);

        try {
            ConsultationRequest::create([
                'name' => $request->name,
                'phone_number' => $request->phone,
                'email' => $request->email ?? null,
                'content' =>  $request->content ?? '',
                'status' => 0,
            ]);
            sleep(2);
            return response()->json(['success' => true, 'message' => 'Xin cảm ơn, form đã được gửi thành công.']);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = ConsultationRequest::query()->findOrFail($id);
            $data->update([
                'status' => 1,
            ]);
//            sleep(2);
            return response()->json(['success' => true, 'message' => 'Cập nhật thàng công.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
