<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Tur",
 *     title="Tür",
 *     description="Film türü modeli",
 *     @OA\Property(property="id", type="integer", example=1, description="Benzersiz ID"),
 *     @OA\Property(property="adi", type="string", example="Aksiyon", description="Tür adı"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-26T20:27:34.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-26T20:27:34.000000Z")
 * )
 */

class Tur extends Model
{
    protected $table = 'turler';
    
    protected $fillable = [
        'adi'
    ];

    public function filmler()
    {
        return $this->hasMany(Film::class, 'tur_id');
    }
}
