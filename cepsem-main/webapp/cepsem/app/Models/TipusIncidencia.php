<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipusIncidencia extends Model
{
    use HasFactory;

    protected $table = "tipus_incidencies";
    public $timestamps = false;

    /**
     * Get all of the incidencies for the TipusIncidencia
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidencies()
    {
        return $this->hasMany(Incidencia::class, 'tipus_incidencia_id');
    }

}
