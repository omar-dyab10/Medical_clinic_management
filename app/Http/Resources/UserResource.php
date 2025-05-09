<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\PatientResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'doctors' => DoctorResource::collection($this->whenLoaded('doctors')),
            'patients' => PatientResource::collection($this->whenLoaded('patients')),
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
        ];
    }
}
