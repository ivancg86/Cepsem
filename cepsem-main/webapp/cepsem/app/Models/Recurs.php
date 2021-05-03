<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurs extends Model
{
    use HasFactory;

    protected $table = "recursos";
    public $timestamps = false;
    protected $fillable = ['codi', 'actiu', 'tipus_recursos_id'];

    /**
     * The incidencies that belong to the Recurs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function incidencies()
    {
        return $this->belongsToMany(Recurs::class, 'incidencies_has_recursos', 'recursos_id', 'incidencies_id')->withPivot('hora_activacio', 'hora_mobilitzacio', 'hora_assistencia', 'hora_transport', 'hora_arribada_hospital', 'hora_transferencia', 'hora_finalitzacio', 'prioritat', 'desti');
    }

    /**
     * Get the tipus_recurs that owns the Recurs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipus_recurs()
    {
        return $this->belongsTo(TipusRecurs::class, 'tipus_recursos_id');
    }

    /**
     * Get all of the usuaris for the Recurs
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usuaris()
    {
        return $this->hasMany(Usuari::class, 'recursos_id');
    }

    /**
     * Get all of the incidencia_has_recursos for the Recurs
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidencia_has_recursos()
    {
        return $this->hasMany(IncidenciaHasRecurs::class, 'recursos_id');
    }
}
