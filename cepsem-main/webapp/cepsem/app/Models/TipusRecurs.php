<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipusRecurs extends Model
{
    use HasFactory;

    protected $table = "tipus_recursos";
    public $timestamps = false;

    /**
     * Get all of the recursos for the TipusRecurs
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recursos()
    {
        return $this->hasMany(Recurs::class, 'tipus_recurs_id');
    }
}
