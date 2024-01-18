<?php

namespace Modules\News\app\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Modules\News\app\Interfaces\RepositoryInterface;

interface LanguageRepositoryInterface extends RepositoryInterface
{
    public function getById(int $languageId);
    public function getByPrefix(array $prefixes): Collection;
}
