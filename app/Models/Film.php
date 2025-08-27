<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Film",
 *     title="Film",
 *     description="Film modeli",
 *     @OA\Property(property="id", type="integer", example=1, description="Benzersiz ID"),
 *     @OA\Property(property="adi", type="string", example="The Matrix", description="Film adı"),
 *     @OA\Property(property="konusu", type="string", example="Bir bilgisayar programcısı...", description="Film konusu"),
 *     @OA\Property(property="imdb_puani", type="number", format="float", example=8.7, description="IMDB puanı"),
 *     @OA\Property(property="tur_id", type="integer", example=1, description="Tür ID'si"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="tur", ref="#/components/schemas/Tur", description="Film türü"),
 *     @OA\Property(property="oyuncular", type="array", @OA\Items(ref="#/components/schemas/Oyuncu"), description="Film oyuncuları")
 * )
 */

class Film extends Model
{
    protected $table = 'filmler';
    
    protected $fillable = [
        'adi',
        'konusu',
        'imdb_puani',
        'tur_id'
    ];

    protected $casts = [
        'imdb_puani' => 'decimal:1'
    ];

    public function tur()
    {
        return $this->belongsTo(Tur::class, 'tur_id');
    }

    public function oyuncular()
    {
        return $this->hasMany(Oyuncu::class, 'film_id');
    }
}
