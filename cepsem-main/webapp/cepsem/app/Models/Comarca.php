<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comarca extends Model
{
    use HasFactory;

    protected $table = "comarques";
    public $timestamps = false;

    /**
     * Get all of the municipis for the Comarca
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function municipis()
    {
        return $this->hasMany(Municipi::class, 'comarques_id');
    }

    /**
     * Get the provincia that owns the Comarca
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincies_id');
    }
}
