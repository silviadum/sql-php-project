<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Membri extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'membri';
    protected $primaryKey = 'id_membru';

    protected $fillable = [
        'nume',
        'prenume',
        'data_nasterii',
        'email',
        'telefon',
        'parola',
        'id_antrenor'
    ];

    protected $hidden = [
        'parola',
    ];

    public function getAuthPassword()
    {
        return $this->parola;
    }

    public function antrenor()
    {
        return $this->belongsTo(Antrenori::class, 'id_antrenor');
    }

    public function abonamente()
    {
        return $this->hasMany(Abonamente::class, 'id_membru');
    }

    public function clase()
    {
        return $this->belongsToMany(Clase::class, 'membri_clase', 'id_membru', 'id_clasa')
                    ->withPivot('feedback');
    }

    public function abonamentActiv()
    {
        return $this->hasOne(Abonamente::class, 'id_membru')
                    ->whereDate('data_sfarsit', '>=', now())
                    ->latest('data_sfarsit');
    }
}