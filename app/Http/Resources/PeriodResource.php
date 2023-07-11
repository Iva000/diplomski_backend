<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PeriodResource extends JsonResource
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
            'date' => $this->resource->date,
            'time' => $this->resource->time,
            'price' => $this->resource->price,
            'status' => $this->resource->status,
            'instructor_id' => new InstructorResource($this->resource->instructor_id), //mozda treba u zagradi samo instructor bez id
        ];
    }
}
