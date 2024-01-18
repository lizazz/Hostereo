<?php

namespace Modules\News\app\Resources\Tags;

use Illuminate\Http\Resources\Json\JsonResource;

class OneTagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
