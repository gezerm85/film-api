<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Tur;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $filmler = Film::with(['tur', 'oyuncular.kisi'])->get();
        return response()->json(['data' => $filmler]);
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
            'adi' => 'required|string|max:255',
            'konusu' => 'required|string',
            'imdb_puani' => 'nullable|numeric|between:0,10',
            'tur_id' => 'required|exists:turler,id'
        ]);

        $film = Film::create($request->all());
        return response()->json(['data' => $film->load('tur')], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $film = Film::with(['tur', 'oyuncular.kisi'])->findOrFail($id);
        return response()->json(['data' => $film]);
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
        $film = Film::findOrFail($id);
        
        $request->validate([
            'adi' => 'required|string|max:255',
            'konusu' => 'required|string',
            'imdb_puani' => 'nullable|numeric|between:0,10',
            'tur_id' => 'required|exists:turler,id'
        ]);

        $film->update($request->all());
        return response()->json(['data' => $film->load('tur')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $film = Film::findOrFail($id);
        $film->delete();
        return response()->json(['message' => 'Film başarıyla silindi']);
    }

    /**
     * Türüne göre filmleri getir
     */
    public function getByTur(string $tur_id): JsonResponse
    {
        $filmler = Film::where('tur_id', $tur_id)
            ->with(['tur', 'oyuncular.kisi'])
            ->get();
        
        return response()->json(['data' => $filmler]);
    }

    /**
     * Film ara
     */
    public function search(string $query): JsonResponse
    {
        $filmler = Film::where('adi', 'like', '%' . $query . '%')
            ->orWhere('konusu', 'like', '%' . $query . '%')
            ->with(['tur', 'oyuncular.kisi'])
            ->get();
        
        return response()->json(['data' => $filmler]);
    }
}
