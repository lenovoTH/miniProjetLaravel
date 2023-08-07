<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\ClientResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CompteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'client'=>new ClientResource($this->client_id),
            'fournisseur'=>$this->fournisseur,
            'solde'=>$this->telephone,
            'numero de compte'=>$this->numerocompte,
            'code'=>$this->code,
            'statut'=>$this->statut,
        ];
    }
}
