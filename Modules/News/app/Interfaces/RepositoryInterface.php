<?php

namespace Modules\News\app\Interfaces;

interface RepositoryInterface
{
    public function getAll();
    public function delete(int $itemId);
    public function create(array $item);
}
