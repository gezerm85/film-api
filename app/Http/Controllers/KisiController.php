<?php

namespace App\Http\Controllers;

use App\Models\Kisi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KisiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/kisiler",
     *     summary="Tüm kişileri listele",
     *     description="Veritabanındaki tüm kişileri (oyuncu, yönetmen vs.) getirir",
     *     tags={"Kişiler"},
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Kisi"))
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     path="/kisiler",
     *     summary="Yeni kişi ekle",
     *     description="Veritabanına yeni bir kişi (oyuncu, yönetmen vs.) ekler",
     *     tags={"Kişiler"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"adi"},
     *             @OA\Property(property="adi", type="string", example="Keanu Reeves", description="Kişi adı")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Kişi başarıyla oluşturuldu",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Kisi")
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

        $kisi = Kisi::create($request->all());
        return response()->json(['data' => $kisi], 201);
    }

    /**
     * @OA\Get(
     *     path="/kisiler/{id}",
     *     summary="Belirli kişiyi getir",
     *     description="ID'ye göre belirli bir kişiyi getirir",
     *     tags={"Kişiler"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Kişi ID'si",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Başarılı",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Kisi")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kişi bulunamadı"
     *     )
     * )
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
     * @OA\Put(
     *     path="/kisiler/{id}",
     *     summary="Kişi güncelle",
     *     description="Belirli bir kişinin bilgilerini günceller",
     *     tags={"Kişiler"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Kişi ID'si",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"adi"},
     *             @OA\Property(property="adi", type="string", example="Keanu Reeves", description="Kişi adı")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Kişi başarıyla güncellendi",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Kisi")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kişi bulunamadı"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Doğrulama hatası"
     *         )
     *     )
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
     * @OA\Delete(
     *     path="/kisiler/{id}",
     *     summary="Kişi sil",
     *     description="Belirli bir kişiyi veritabanından siler",
     *     tags={"Kişiler"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Kişi ID'si",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Kişi başarıyla silindi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Kişi başarıyla silindi")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kişi bulunamadı"
     *     )
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        $kisi = Kisi::findOrFail($id);
        $kisi->delete();
        return response()->json(['message' => 'Kişi başarıyla silindi']);
    }
}
