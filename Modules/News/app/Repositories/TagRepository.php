<?php

namespace Modules\News\app\Repositories;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\News\app\Interfaces\TagRepositoryInterface;
use Modules\News\app\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class TagRepository implements TagRepositoryInterface
{
    public function getAll(): LengthAwarePaginator
    {
        return Tag::paginate(10);
    }

    public function getById(int $tagId): Tag
    {
        return Tag::findOrFail($tagId);
    }

    public function delete(int $tagId)
    {
        $tag = Tag::find($tagId);
        $tag->posts()->detach();

        $tag->delete();
    }

    public function create(array $item): Tag
    {
        return Tag::create($item);
    }

    public function update(int $tagId, array $newDetails): int
    {
        return Tag::whereId($tagId)->update($newDetails);
    }

    public function getByPost($post): Collection
    {
        return $post->tags;
    }

    public function getFilteredContent($item, array $parameters): BelongsToMany
    {
        return $item->tags()->whereIn('name', $parameters);
    }

    public function addGet($builder): Collection
    {
        return $builder->get();
    }
}
