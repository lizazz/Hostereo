<?php

namespace Modules\News\app\Resources\Tags;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\News\app\Models\Tag;

class TagCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     */
    public function toArray($request): array
    {
        return $this->collection->transform(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name
            ];
        })->toArray();
    }
}
