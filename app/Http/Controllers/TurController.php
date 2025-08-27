<?php

namespace App\Http\Controllers;

use App\Models\Tur;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     title="Sinema API",
 *     version="1.0.0",
 *     description="Film, tür, kişi ve oyuncu yönetimi için RESTful API",
 *     @OA\Contact(
 *         email="developer@example.com",
 *         name="API Geliştirici"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Local API Server"
 * )
 */

class TurController extends Controller
{
    /**
     * @OA\Get(
     *     path="/turler",
     *     summary="Tüm türleri listele",
     *     description="Veritabanındaki tüm film türlerini getirir",
     *     tags={"Türler"},
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Tur"))
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     path="/turler",
     *     summary="Yeni tür ekle",
     *     description="Veritabanına yeni bir film türü ekler",
     *     tags={"Türler"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"adi"},
     *             @OA\Property(property="adi", type="string", example="Aksiyon", description="Tür adı")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tür başarıyla oluşturuldu",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Tur")
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
            'adi' => 'required|string|max:255'
        ]);

        $tur = Tur::create($request->all());
        return response()->json(['data' => $tur], 201);
    }

    /**
     * @OA\Get(
     *     path="/turler/{id}",
     *     summary="Belirli türü getir",
     *     description="ID'ye göre belirli bir film türünü getirir",
     *     tags={"Türler"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Tür ID'si",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Tur")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tür bulunamadı"
     *     )
     * )
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
     * @OA\Put(
     *     path="/turler/{id}",
     *     summary="Tür güncelle",
     *     description="Belirli bir film türünün bilgilerini günceller",
     *     tags={"Türler"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Tür ID'si",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"adi"},
     *             @OA\Property(property="adi", type="string", example="Aksiyon", description="Tür adı")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tür başarıyla güncellendi",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Tur")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tür bulunamadı"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Doğrulama hatası"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/turler/{id}",
     *     summary="Tür sil",
     *     description="Belirli bir film türünü veritabanından siler",
     *     tags={"Türler"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Tür ID'si",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tür başarıyla silindi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Tür başarıyla silindi")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tür bulunamadı"
     *     )
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        $tur = Tur::findOrFail($id);
        $tur->delete();
        return response()->json(['message' => 'Tür başarıyla silindi']);
    }
}
