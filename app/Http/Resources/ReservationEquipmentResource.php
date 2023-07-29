<?php

namespace App\Http\Resources;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationEquipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return [
        //     'reservation' => new ReservationResource($this->resource->reservation),
        //     'equipment' => new EquipmentResource($this->resource->equipment),
        //     'equipmentInformation' => $this->resource->equipmentInformation,
        // ];
        $data = [
            'equipmentInformation' => $this->resource->equipmentInformation,
        ];

        if ($this->resource->reservation) {
            $data['reservation'] = new ReservationResource($this->resource->reservation);
        }

        if ($this->resource->equipment) {
            $data['equipment'] = new EquipmentResource($this->resource->equipment);
        }

        return $data;
    }
}
