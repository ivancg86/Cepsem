<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuari extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = "usuaris";
    public $timestamps = false;
    protected $fillable = ['username', 'contrasenya', 'email', 'nom', 'cognoms', 'rols_id', 'recursos_id'];

    /**
     * Get all of the incidencies for the Usuari
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidencies()
    {
        return $this->hasMany(Incidencia::class, 'usuaris_id');
    }

    /**
     * Get the recurs that owns the Usuari
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recurs()
    {
        return $this->belongsTo(Recurs::class, 'recursos_id');
    }

    /**
     * Get the rol that owns the Usuari
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rols_id');
    }
}
