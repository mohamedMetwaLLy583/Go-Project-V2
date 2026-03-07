<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DayResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'short_name_ar' => $this->short_name_ar,
            'short_name_en' => $this->short_name_en,
            'order' => $this->order,
        ];
    }
}