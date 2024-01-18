<?php

namespace Modules\News\app\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\News\app\Interfaces\RepositoryInterface;
use Modules\News\app\Models\Post;

interface PostTranslationRepositoryInterface extends RepositoryInterface
{
    public function getAll();
    public function getById(int $itemId);
    public function delete(int $itemId);
    public function createMany(Post $post, array $details);
    public function updateMany(Post $post, array $details);
    public function getPost(int $itemId);
    public function getByPost(int $post);
    public function getFilteredContent(Post $item, array $parameters);
    public function addWhereIn($builder, string $field, array $parameters);
    public function addGet($builder);
}
