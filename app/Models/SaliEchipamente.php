<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SaliEchipamente extends Pivot
{
    protected $table = 'sali_echipamente';
    public $timestamps = false;

    protected $fillable = [
        'id_sala',
        'id_echipament',
        'bucati'
    ];

    public function sala()
    {
        return $this->belongsTo(Sali::class, 'id_sala');
    }

    public function echipament()
    {
        return $this->belongsTo(Echipamente::class, 'id_echipament');
    }
}