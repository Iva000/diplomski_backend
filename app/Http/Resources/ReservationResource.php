<?php

namespace App\Http\Resources;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'totalPrice' => $this->resource->totalPrice,
            'period' => new PeriodResource($this->resource->period), //mozda bez id u zagradi
            'equipment' => new EquipmentResource($this->resource->equipment), //mozda bez id
            'equipmentDescription' => $this->resource->equipmentDescription,
            'user' => new UserResource($this->resource->user), //mozda bez id
            'status' => $this->resource->status,
        ];
    }
}
