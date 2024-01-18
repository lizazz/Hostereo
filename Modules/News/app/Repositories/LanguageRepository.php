<?php

namespace Modules\News\app\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\News\app\Interfaces\LanguageRepositoryInterface;
use Modules\News\app\Models\Language;

class LanguageRepository implements LanguageRepositoryInterface
{
    public function getAll(): LengthAwarePaginator
    {
        return Language::paginate(10);
    }

    public function getById(int $languageId): Language
    {
        return Language::findOrFail($languageId);
    }
    public function getByPrefix(array $prefixes): Collection
    {
        return Language::whereIn('prefix', $prefixes)->get();
    }

    public function delete(int $tagId)
    {
        Language::find($tagId)->delete();
    }

    public function create(array $item): Language
    {
        return Language::create($item);
    }
}
