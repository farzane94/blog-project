<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRankingResource extends JsonResource
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
        'name' => $this->name,
        'profile_image' => $this->profile_image
            ? asset('storage/' . $this->profile_image)
            : null,
        'total_views' => $this->total_views,
    ];
    }
}
