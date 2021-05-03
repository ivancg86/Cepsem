<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipusAlertant extends Model
{
    use HasFactory;

    protected $table = "tipus_alertants";
    public $timestamps = false;

    /**
     * Get all of the alertants for the TipusAlertant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alertants()
    {
        return $this->hasMany(Alertant::class, 'foreign_key', 'local_key');
    }
}
