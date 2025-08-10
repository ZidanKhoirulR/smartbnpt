<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NilaiAkhirResource extends JsonResource
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
            'alternatif_id' => $this->alternatif_id,
            'kriteria_id' => $this->kriteria_id,
            'nilai' => $this->nilai,
            'alternatif' => new AlternatifResource($this->whenLoaded('alternatif')),
            'kriteria' => new KriteriaResource($this->whenLoaded('kriteria')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}