<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidenciaHasRecurs extends Model
{
    use HasFactory;

    protected $table = "incidencies_has_recursos";
    public $primaryKey = ['incidencies_id', 'recursos_id', 'afectats_id'];
    public $incrementing = false;
    public $timestamps = false;

    /**
     * Get the incidencia that owns the IncidenciaHasRecurs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class, 'incidencies_id');
    }

    /**
     * Get the recurs that owns the IncidenciaHasRecurs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recurs()
    {
        return $this->belongsTo(Recurs::class, 'recursos_id');
    }

    /**
     * Get the afectat that owns the IncidenciaHasRecurs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function afectat()
    {
        return $this->belongsTo(Afectat::class, 'afectats_id');
    }
}
?>
