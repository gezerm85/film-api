<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Oyuncu",
 *     title="Oyuncu",
 *     description="Film-kişi ilişki modeli",
 *     @OA\Property(property="id", type="integer", example=1, description="Benzersiz ID"),
 *     @OA\Property(property="film_id", type="integer", example=1, description="Film ID'si"),
 *     @OA\Property(property="kisi_id", type="integer", example=1, description="Kişi ID'si"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="film", ref="#/components/schemas/Film", description="İlgili film"),
 *     @OA\Property(property="kisi", ref="#/components/schemas/Kisi", description="İlgili kişi")
 * )
 */

class Oyuncu extends Model
{
    protected $table = 'oyuncular';
    
    protected $fillable = [
        'film_id',
        'kisi_id'
    ];

    public function film()
    {
        return $this->belongsTo(Film::class, 'film_id');
    }

    public function kisi()
    {
        return $this->belongsTo(Kisi::class, 'kisi_id');
    }
}
