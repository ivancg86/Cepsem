<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipi extends Model
{
    use HasFactory;

    protected $table = "municipis";
    public $timestamps = false;

    /**
     * Get all of the incidencies for the Municipi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidencies()
    {
        return $this->hasMany(Incidencia::class, 'municipis_id');
    }

    /**
     * Get the comarca that owns the Municipi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comarca()
    {
        return $this->belongsTo(Comarca::class, 'comarques_id'                             );
    }
}
