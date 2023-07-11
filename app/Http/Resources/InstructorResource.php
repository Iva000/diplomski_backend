<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorResource extends JsonResource
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
            'name' => $this->resource->name,
            'surname' => $this->resource->surname,
            'skiSchool' => $this->resource->skiSchool,
            'experience' => $this->resource->experience,
            'price' => $this->resource->price,
            'activity' => $this->resource->activity,
            'description' => $this->resource->description,
            'email' => $this->resource->email,
            'password' => $this->resource->password,
            'phoneNumber' => $this->resource->phoneNumber,
            'status' => $this->resource->status,
            'photo' => $this->resource->photo,
            'mountain' => new MountainResource($this->resource->mountain)
        ];
    }
}
