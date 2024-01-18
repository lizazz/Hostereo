<?php

namespace Modules\News\app\Rules\Posts;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\News\app\Repositories\LanguageRepository;

class CheckLanguageRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $languageRepository = app(LanguageRepository::class);

        foreach ($value as $language => $item) {
            if (!count($languageRepository->getByPrefix([$language]))) {
                $fail(__('validation.exists', ['attribute' => $language]));
            }
        }
    }
}
