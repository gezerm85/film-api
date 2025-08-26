<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
