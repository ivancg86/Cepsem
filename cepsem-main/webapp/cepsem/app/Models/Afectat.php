<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Afectat extends Model
{
    use HasFactory;

    protected $table = "afectats";
    public $timestamps = false;
    protected $fillable = ['telefon', 'cip', 'nom', 'cognoms', 'edat', 'te_cip', 'sexes_id'];

    /**
     * Get the sexe that owns the Afectat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sexe()
    {
        return $this->belongsTo(Sexe::class, 'sexes_id');
    }


    /**
     * The incidencies that belong to the Afectat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function incidencies()
    {
        return $this->belongsToMany(Incidencia::class, 'incidencies_has_afectats', 'afectats_id', 'incidencies_id');
    }

    /**
     * The recursos that belong to the Afectat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recursos()
    {
        return $this->belongsToMany(Role::class, 'role_user_table', 'user_id', 'role_id');
    }

    /**
     * Get all of the incidencia_has_recursos for the Afectat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidencia_has_recursos()
    {
        return $this->hasMany(IncidenciaHasRecurs::class, 'afectats_id');
    }
}
