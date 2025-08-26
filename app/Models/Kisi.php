<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
