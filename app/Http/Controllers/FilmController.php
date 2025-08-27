<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Tur;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FilmController extends Controller
{
    /**
     * @OA\Get(
     *     path="/filmler",
     *     summary="Tüm filmleri listele",
     *     description="Veritabanındaki tüm filmleri tür ve oyuncu bilgileriyle birlikte getirir",
     *     tags={"Filmler"},
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Film"))
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     path="/filmler",
     *     summary="Yeni film ekle",
     *     description="Veritabanına yeni bir film ekler",
     *     tags={"Filmler"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"adi", "konusu", "tur_id"},
     *             @OA\Property(property="adi", type="string", example="The Matrix", description="Film adı"),
     *             @OA\Property(property="konusu", type="string", example="Bir bilgisayar programcısı...", description="Film konusu"),
     *             @OA\Property(property="imdb_puani", type="number", format="float", example=8.7, description="IMDB puanı (0-10 arası)"),
     *             @OA\Property(property="tur_id", type="integer", example=1, description="Tür ID'si")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Film başarıyla oluşturuldu",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Film")
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
            'adi' => 'required|string|max:255',
            'konusu' => 'required|string',
            'imdb_puani' => 'nullable|numeric|between:0,10',
            'tur_id' => 'required|exists:turler,id'
        ]);

        $film = Film::create($request->all());
        return response()->json(['data' => $film->load('tur')], 201);
    }

    /**
     * @OA\Get(
     *     path="/filmler/{id}",
     *     summary="Belirli filmi getir",
     *     description="ID'ye göre belirli bir filmi tür ve oyuncu bilgileriyle birlikte getirir",
     *     tags={"Filmler"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Film ID'si",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Film")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Film bulunamadı"
     *     )
     * )
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
     * @OA\Put(
     *     path="/filmler/{id}",
     *     summary="Film güncelle",
     *     description="Belirli bir filmin bilgilerini günceller",
     *     tags={"Filmler"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Film ID'si",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"adi", "konusu", "tur_id"},
     *             @OA\Property(property="adi", type="string", example="The Matrix", description="Film adı"),
     *             @OA\Property(property="konusu", type="string", example="Bir bilgisayar programcısı...", description="Film konusu"),
     *             @OA\Property(property="imdb_puani", type="number", format="float", example=8.7, description="IMDB puanı (0-10 arası)"),
     *             @OA\Property(property="tur_id", type="integer", example=1, description="Tür ID'si")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Film başarıyla güncellendi",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Film")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Film bulunamadı"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Doğrulama hatası"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/filmler/{id}",
     *     summary="Film sil",
     *     description="Belirli bir filmi veritabanından siler",
     *     tags={"Filmler"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Film ID'si",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Film başarıyla silindi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Film başarıyla silindi")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Film bulunamadı"
     *     )
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        $film = Film::findOrFail($id);
        $film->delete();
        return response()->json(['message' => 'Film başarıyla silindi']);
    }

    /**
     * @OA\Get(
     *     path="/filmler/tur/{tur_id}",
     *     summary="Türe göre filmleri listele",
     *     description="Belirli bir türe ait filmleri getirir",
     *     tags={"Filmler"},
     *     @OA\Parameter(
     *         name="tur_id",
     *         in="path",
     *         required=true,
     *         description="Tür ID'si",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Film"))
     *         )
     *     )
     * )
     */
    public function getByTur(string $tur_id): JsonResponse
    {
        $filmler = Film::where('tur_id', $tur_id)
            ->with(['tur', 'oyuncular.kisi'])
            ->get();
        
        return response()->json(['data' => $filmler]);
    }

    /**
     * @OA\Get(
     *     path="/filmler/search/{query}",
     *     summary="Film ara",
     *     description="Film adı veya konusuna göre arama yapar",
     *     tags={"Filmler"},
     *     @OA\Parameter(
     *         name="query",
     *         in="path",
     *         required=true,
     *         description="Arama terimi",
     *         @OA\Schema(type="string", example="Matrix")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Film"))
     *         )
     *     )
     * )
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
