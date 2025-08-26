<?php

namespace App\Http\Controllers;

use App\Models\Oyuncu;
use App\Models\Film;
use App\Models\Kisi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OyuncuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $oyuncular = Oyuncu::with(['film', 'kisi'])->get();
        return response()->json(['data' => $oyuncular]);
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
            'film_id' => 'required|exists:filmler,id',
            'kisi_id' => 'required|exists:kisiler,id'
        ]);

        $oyuncu = Oyuncu::create($request->all());
        return response()->json(['data' => $oyuncu->load(['film', 'kisi'])], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $oyuncu = Oyuncu::with(['film', 'kisi'])->findOrFail($id);
        return response()->json(['data' => $oyuncu]);
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
        $oyuncu = Oyuncu::findOrFail($id);
        
        $request->validate([
            'film_id' => 'required|exists:filmler,id',
            'kisi_id' => 'required|exists:kisiler,id'
        ]);

        $oyuncu->update($request->all());
        return response()->json(['data' => $oyuncu->load(['film', 'kisi'])]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $oyuncu = Oyuncu::findOrFail($id);
        $oyuncu->delete();
        return response()->json(['message' => 'Oyuncu başarıyla silindi']);
    }
}
