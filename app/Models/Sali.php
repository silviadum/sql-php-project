<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sali extends Model
{
    use HasFactory;

    protected $table = 'sali';
    protected $primaryKey = 'id_sala';
    public $timestamps = false;

    protected $fillable = [
        'denumire_sala',
        'capacitate'
    ];

    public function clase()
    {
        return $this->hasMany(Clase::class, 'id_sala');
    }

    public function echipamente()
    {
        return $this->belongsToMany(Echipamente::class, 'sali_echipamente', 'id_sala', 'id_echipament')
                    ->withPivot('bucati');
    }
}