<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidenciaHasAfectat extends Model
{
    use HasFactory;

    protected $table = "incidencies_has_afectats";
    public $primaryKey = ['incidencies_id', 'afectats_id'];
    public $incrementing = false;
    public $timestamps = false;


    /**
     * Get the incidencia that owns the IncidenciaHasAfectat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class, 'incidencies_id');
    }

    /**
     * Get the afectat that owns the IncidenciaHasAfectat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function afectat()
    {
        return $this->belongsTo(Afectat::class, 'afectats_id');
    }
}
?>
