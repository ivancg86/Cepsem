<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;

    protected $table = "incidencies";
    public $timestamps = false;

    /**
     * The afectats that belong to the Incidencia
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function afectats()
    {
        return $this->belongsToMany(Incidencia::class, 'incidencies_has_afectats', 'incidencies_id', 'afectats_id');
    }

    /**
     * Get the tipus_incidencia that owns the Incidencia
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipus_incidencia()
    {
        return $this->belongsTo(TipusIncidencia::class, 'tipus_incidencies_id');
    }

    /**
     * The recursos that belong to the Incidencia
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recursos()
    {
        return $this->belongsToMany(Recurs::class, 'incidencies_has_recursos', 'incidencies_id', 'recursos_id', 'afectats_id')->withPivot('hora_activacio', 'hora_mobilitzacio', 'hora_assistencia', 'hora_transport', 'hora_arribada_hospital', 'hora_transferencia', 'hora_finalitzacio', 'prioritat', 'desti');
    }


    /**
     * Get the municipi that owns the Incidencia
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipi()
    {
        return $this->belongsTo(Municipi::class, 'municipis_id');
    }

    /**
     * Get the alertant that owns the Incidencia
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alertant()
    {
        return $this->belongsTo(Alertant::class, 'alertants_id');
    }

    /**
     * Get the usuari that owns the Incidencia
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuari()
    {
        return $this->belongsTo(Usuari::class, 'usuaris_id');
    }

    /**
     * Get all of the incidencia_has_recursos for the Incidencia
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidencia_has_recursos()
    {
        return $this->hasMany(IncidenciaHasRecurs::class, 'incidencies_id');
    }
}
