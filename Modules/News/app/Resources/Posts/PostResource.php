<?php

namespace Modules\News\app\Resources\Posts;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\News\app\Repositories\LanguageRepository;
use Modules\News\app\Repositories\PostTranslationRepository;
use Modules\News\app\Repositories\TagRepository;
use Modules\News\app\Resources\PostTranslations\PostTranslationCollectionResource;
use Modules\News\app\Resources\Tags\TagCollectionResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $postTranslationRepository = app(PostTranslationRepository::class);
        $tagRepository = app(TagRepository::class);

        return [
            'id' => $this->id,
            'translations' => new PostTranslationCollectionResource($postTranslationRepository->getByPost($this->id)),
            'tags' => new TagCollectionResource($tagRepository->getByPost($this))
        ];
    }
}
