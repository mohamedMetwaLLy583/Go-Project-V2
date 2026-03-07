<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'age' => $this->age,
            'neighborhood' => $this->neighborhoods,
            'nationality' => $this->nationality,
            'profile_picture' => url($this->profile_picture),
            'rating' => $this->average_rating ?? 0,
            'accept_smoking' => $this->accept_smoking,
            'accept_others' => $this->accept_others,
            'car_type' => $this->car_type,

            'car_photos' => $this->carImages->map(
                fn($image) => url($image->image_path)
            ),
        ];
    }
}
