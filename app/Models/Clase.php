<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    protected $table = 'clase';
    protected $primaryKey = 'id_clasa';
    public $timestamps = false;

    protected $fillable = [
        'denumire_clasa',
        'durata',
        'id_antrenor',
        'id_sala'
    ];

    public function antrenor()
    {
        return $this->belongsTo(Antrenori::class, 'id_antrenor');
    }

    public function sala()
    {
        return $this->belongsTo(Sali::class, 'id_sala');
    }

    public function membri()
    {
        return $this->belongsToMany(Membri::class, 'membri_clase', 'id_clasa', 'id_membru')
                    ->withPivot('feedback');
    }

    public function getNumarInscrisiAttribute()
    {
        return $this->membri()->count();
    }

    public function getLocuriDisponibileAttribute()
    {
        return $this->sala->capacitate - $this->numar_inscrisi;
    }

    public function isPlina()
    {
        return $this->numar_inscrisi >= $this->sala->capacitate;
    }
}