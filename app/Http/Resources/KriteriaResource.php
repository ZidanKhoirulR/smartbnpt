<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KriteriaResource extends JsonResource
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
            'kode' => $this->kode,
            'kriteria' => $this->kriteria,
            'ranking' => $this->ranking,
            'jenis_kriteria' => $this->jenis_kriteria,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}