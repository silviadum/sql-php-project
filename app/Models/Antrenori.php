<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrenori extends Model
{
    use HasFactory;

    protected $table = 'antrenori';
    protected $primaryKey = 'id_antrenor';
    public $timestamps = false;

    protected $fillable = [
        'nume',
        'prenume',
        'specializare',
        'email',
        'telefon',
        'parola'
    ];

    protected $hidden = [
        'parola',
    ];

    public function membri()
    {
        return $this->hasMany(Membri::class, 'id_antrenor');
    }

    public function clase()
    {
        return $this->hasMany(Clase::class, 'id_antrenor');
    }
}