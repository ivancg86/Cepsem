<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sexe extends Model
{
    use HasFactory;

    protected $table = "sexes";
    public $timestamps = false;

    /**
     * Get all of the afectats for the Sexe
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function afectats()
    {
        return $this->hasMany(Afectat::class, 'sexes_id');
    }

}
