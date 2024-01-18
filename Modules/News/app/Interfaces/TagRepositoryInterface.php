<?php

namespace Modules\News\app\Interfaces;

use Modules\News\app\Interfaces\RepositoryInterface;

interface TagRepositoryInterface extends RepositoryInterface
{
    public function getAll();
    public function getById(int $itemId);
    public function delete(int $itemId);
    public function create(array $item);
    public function update(int $itemId, array $newDetails);
    public function getByPost(Post $post);
    public function getFilteredContent($item, array $parameters);
    public function addGet($builder);
}
