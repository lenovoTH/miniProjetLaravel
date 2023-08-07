<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CompteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'id' => $this->id,
            // 'expediteur'=>new CompteResource($this->expediteur_id),
            // 'recepteur'=>new CompteResource($this->recepteur_id),
        ];
    }
}
