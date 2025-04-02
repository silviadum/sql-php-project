<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Echipamente extends Model
{
    use HasFactory;

    protected $table = 'echipamente';
    protected $primaryKey = 'id_echipament';
    public $timestamps = false;

    protected $fillable = [
        'denumire_echipament',
        'necesita_achizitie'
    ];

    protected $casts = [
        'necesita_achizitie' => 'boolean'
    ];

    public function sali()
    {
        return $this->belongsToMany(Sali::class, 'sali_echipamente', 'id_echipament', 'id_sala')
                    ->withPivot('bucati');
    }

    public function getTotalBucatiAttribute()
    {
        return $this->sali()->sum('sali_echipamente.bucati');
    }

    public function getNumarSaliAttribute()
    {
        return $this->sali()->count();
    }
}