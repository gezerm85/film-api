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
     * @OA\Get(
     *     path="/oyuncular",
     *     summary="Tüm oyuncuları listele",
     *     description="Veritabanındaki tüm oyuncu-film ilişkilerini getirir",
     *     tags={"Oyuncular"},
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Oyuncu"))
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     path="/oyuncular",
     *     summary="Yeni oyuncu ekle",
     *     description="Veritabanına yeni bir oyuncu-film ilişkisi ekler",
     *     tags={"Oyuncular"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"film_id", "kisi_id"},
     *             @OA\Property(property="film_id", type="integer", example=1, description="Film ID'si"),
     *             @OA\Property(property="kisi_id", type="integer", example=1, description="Kişi ID'si")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Oyuncu başarıyla eklendi",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Oyuncu")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Doğrulama hatası"
     *     )
     * )
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
     * @OA\Get(
     *     path="/oyuncular/{id}",
     *     summary="Belirli oyuncuyu getir",
     *     description="ID'ye göre belirli bir oyuncu-film ilişkisini getirir",
     *     tags={"Oyuncular"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Oyuncu ID'si",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Oyuncu")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Oyuncu bulunamadı"
     *     )
     * )
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
     * @OA\Put(
     *     path="/oyuncular/{id}",
     *     summary="Oyuncu güncelle",
     *     description="Belirli bir oyuncu-film ilişkisini günceller",
     *     tags={"Oyuncular"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Oyuncu ID'si",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"film_id", "kisi_id"},
     *             @OA\Property(property="film_id", type="integer", example=1, description="Film ID'si"),
     *             @OA\Property(property="kisi_id", type="integer", example=1, description="Kişi ID'si")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Oyuncu başarıyla güncellendi",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Oyuncu")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Oyuncu bulunamadı"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Doğrulama hatası"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/oyuncular/{id}",
     *     summary="Oyuncu sil",
     *     description="Belirli bir oyuncu-film ilişkisini veritabanından siler",
     *     tags={"Oyuncular"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Oyuncu ID'si",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Oyuncu başarıyla silindi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Oyuncu başarıyla silindi")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Oyuncu bulunamadı"
     *     )
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        $oyuncu = Oyuncu::findOrFail($id);
        $oyuncu->delete();
        return response()->json(['data' => $oyuncu->load(['film', 'kisi'])]);
    }
}
