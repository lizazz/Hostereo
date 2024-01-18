<?php

namespace Modules\News\app\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\News\app\Interfaces\PostTranslationRepositoryInterface;
use Modules\News\app\Models\Post;
use Modules\News\app\Models\PostTranslation;

class PostTranslationRepository implements PostTranslationRepositoryInterface
{

    public function getAll(): LengthAwarePaginator
    {
        return PostTranslation::paginate(10);
    }

    public function getById(int $postTranslationId): PostTranslation
    {
        return PostTranslation::findOrFail($postTranslationId);
    }

    public function delete(int $postTranslationId)
    {
        PostTranslation::destroy($postTranslationId);
    }


    public function createMany(Post $post, array $details): Post
    {
        $post->translations()->createMany($details);
        return $post->refresh();
    }

    public function updateMany(Post $post, array $newDetails)
    {
        $post->translations()->delete();
        $post->translations()->createMany($newDetails);
    }

    public function getPost(int $postTranslationId)
    {
        return $this->getById($postTranslationId)->post;
    }

    public function create(array $item): PostTranslation
    {
        return PostTranslation::create($item);
    }
    public function getByPost(int $postId): Collection
    {
        return PostTranslation::wherePostId($postId)->get();
    }

    public function getFilteredContent(Post $item, array $parameters): HasMany
    {
        $builder = $item->translations();
        $contentParameters = array_filter($parameters, function($parameter) {
            return in_array($parameter, ['title', 'description', 'content']);
        }, ARRAY_FILTER_USE_KEY);

        foreach ($contentParameters as $name => $parameter) {
            $builder->where($name, 'LIKE', "%" . $parameter . '%');
        }

        return $builder;
    }

    public function addWhereIn($builder, string $field, array $parameters): HasMany
    {
        return $builder->whereIn($field, $parameters);
    }

    public function addGet($builder): Collection
    {
        return $builder->get();
    }
}
