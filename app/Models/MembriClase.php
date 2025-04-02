<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MembriClase extends Pivot
{
    protected $table = 'membri_clase';
    public $timestamps = false;

    protected $fillable = [
        'id_membru',
        'id_clasa',
        'feedback'
    ];

    public function membru()
    {
        return $this->belongsTo(Membri::class, 'id_membru');
    }

    public function clasa()
    {
        return $this->belongsTo(Clase::class, 'id_clasa');
    }
}