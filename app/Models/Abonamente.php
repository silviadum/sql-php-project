<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonamente extends Model
{
    use HasFactory;

    protected $table = 'abonamente';
    protected $primaryKey = 'id_abonament';
    public $timestamps = false;

    protected $fillable = [
        'tip_abonament',
        'pret',
        'data_incepere',
        'data_sfarsit',
        'id_membru'
    ];

    protected $dates = [
        'data_incepere',
        'data_sfarsit'
    ];

    public function membru()
    {
        return $this->belongsTo(Membri::class, 'id_membru');
    }

    public function isActiv()
    {
        return $this->data_sfarsit >= now();
    }

    public function getRamaseDays()
    {
        return now()->diffInDays($this->data_sfarsit, false);
    }
}