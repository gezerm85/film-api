<?php

namespace App\Http\Controllers;

use App\Models\Kisi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $kisiler = Kisi::all();
        return response()->json(['data' => $kisiler]);
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
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'adi' => 'required|string|max:255'
        ]);

        $kisi = Kisi::create($request->all());
        return response()->json(['data' => $kisi], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $kisi = Kisi::findOrFail($id);
        return response()->json(['data' => $kisi]);
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
    public function update(Request $request, string $id): JsonResponse
    {
        $kisi = Kisi::findOrFail($id);
        
        $request->validate([
            'adi' => 'required|string|max:255'
        ]);

        $kisi->update($request->all());
        return response()->json(['data' => $kisi]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $kisi = Kisi::findOrFail($id);
        $kisi->delete();
        return response()->json(['message' => 'Kişi başarıyla silindi']);
    }
}
