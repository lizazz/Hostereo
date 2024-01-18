<?php

namespace Modules\News\app\Resources\PostTranslations;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\News\app\Repositories\LanguageRepository;

class PostTranslationCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     */
    public function toArray($request): array
    {
        $postTranslations = [];
        $languageRepository = app(LanguageRepository::class);

        foreach ($this->collection as $item) {
            $language = $languageRepository->getById($item->language_id);
            $postTranslations[$language->prefix] = [
                'title' => $item->title,
                'description' => $item->description,
                'content' => $item->content
            ];
        }

        return $postTranslations;
    }
}
