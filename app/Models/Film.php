<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
