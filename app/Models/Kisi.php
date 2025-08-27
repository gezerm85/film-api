<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Kisi",
 *     title="Kişi",
 *     description="Kişi modeli (oyuncu, yönetmen vs.)",
 *     @OA\Property(property="id", type="integer", example=1, description="Benzersiz ID"),
 *     @OA\Property(property="adi", type="string", example="Keanu Reeves", description="Kişi adı"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

class Kisi extends Model
{
    protected $table = 'kisiler';
    
    protected $fillable = [
        'adi'
    ];

    public function oyuncular()
    {
        return $this->hasMany(Oyuncu::class, 'kisi_id');
    }
}
