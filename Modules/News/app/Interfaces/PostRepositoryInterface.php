<?php

namespace Modules\News\app\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\News\app\Interfaces\RepositoryInterface;

interface PostRepositoryInterface extends RepositoryInterface
{
    public function getAll();
    public function getById(int $itemId);
    public function delete(int $itemId);
    public function create(array $item);
    public function getAllWithPagination(): LengthAwarePaginator;
}
