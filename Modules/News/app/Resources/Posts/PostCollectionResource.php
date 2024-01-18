<?php

namespace Modules\News\app\Resources\Posts;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\News\app\Repositories\PostTranslationRepository;
use Modules\News\app\Repositories\TagRepository;
use Modules\News\app\Resources\PostTranslations\PostTranslationCollectionResource;
use Modules\News\app\Resources\Tags\TagCollectionResource;

class PostCollectionResource extends ResourceCollection
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        $postTranslationRepository = app(PostTranslationRepository::class);
        $tagRepository = app(TagRepository::class);

        return $this->collection->transform(function ($item) use ($postTranslationRepository, $tagRepository) {
            return [
                'id' => $item->id,
                'translations' => new PostTranslationCollectionResource($postTranslationRepository->getByPost($item->id)),
                'tags' => new TagCollectionResource($tagRepository->getByPost($item))
            ];
        })->toArray();
    }
}
