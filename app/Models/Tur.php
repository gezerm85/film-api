<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
