<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlertantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        // return [
        //     "id" => $this->id,
        //     "nom" => $this->nom,
        //     "cognoms" => $this->cognoms,
        //     "telefon" => $this->telefon,
        //     "adreca" => $this->adreca,
        // ];
    }
}
