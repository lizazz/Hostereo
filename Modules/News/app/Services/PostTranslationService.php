<?php

namespace Modules\News\app\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Modules\News\app\Interfaces\RepositoryInterface;
use Modules\News\app\Models\Post;
use Modules\News\app\Models\PostTranslation;
use Modules\News\app\Repositories\LanguageRepository;
use Modules\News\app\Repositories\PostTranslationRepository;
use Modules\News\app\Repositories\TagRepository;

class PostTranslationService
{
    public array $translationParametersKey = ['title', 'description', 'content', 'languages'];
    private RepositoryInterface $repository;
    private LanguageRepository $languageRepository;
    private TagRepository $tagRepository;

    public function __construct(
        PostTranslationRepository $postTranslationRepository,
        LanguageRepository $languageRepository,
        TagRepository $tagRepository
    ) {
        $this->repository = $postTranslationRepository;
        $this->languageRepository = $languageRepository;
        $this->tagRepository = $tagRepository;
    }

    public function prepareForSave($post, $details): array
    {
        $translations = [];

        foreach ($details as $languagePrefix => $detail) {
            $languages = $this->languageRepository->getByPrefix([$languagePrefix]);
            $detail['language_id'] = $languages[0]->id;
            $detail['post_id'] = $post->id;
            $translations[] = $detail;
        }

        return $translations;
    }

    public function filter(Collection $posts, array $parameters): Collection
    {
        return $posts->filter(function ($item) use ($parameters) {
            $isFit = true;

            if (array_intersect_key(array_keys($parameters), $this->translationParametersKey)) {
                $builder = $this->repository->getFilteredContent($item, $parameters);

                if (isset($parameters['languages']) && count($parameters['languages'])) {
                    $languageIds = $this->languageRepository->getByPrefix($parameters['languages'])->pluck('id');
                    $builder = $this->repository->addWhereIn($builder, 'language_id', $languageIds->toArray());
                }

                $isFit = count($this->repository->addGet($builder));
            }

            if ($isFit && isset($parameters['tags']) && count($parameters['tags'])) {
                $builder = $this->tagRepository->getFilteredContent($item, $parameters['tags']);
                $isFit = count($this->tagRepository->addGet($builder));
            }

            return $isFit;
        });
    }
}
