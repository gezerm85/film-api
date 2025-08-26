<?php

namespace App\Http\Controllers;

use App\Models\Tur;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $turler = Tur::all();
        return response()->json(['data' => $turler]);
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

        $tur = Tur::create($request->all());
        return response()->json(['data' => $tur], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $tur = Tur::findOrFail($id);
        return response()->json(['data' => $tur]);
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
        $tur = Tur::findOrFail($id);
        
        $request->validate([
            'adi' => 'required|string|max:255'
        ]);

        $tur->update($request->all());
        return response()->json(['data' => $tur]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $tur = Tur::findOrFail($id);
        $tur->delete();
        return response()->json(['message' => 'Tür başarıyla silindi']);
    }
}
