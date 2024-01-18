<?php

namespace Modules\News\app\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;
use Modules\News\app\Rules\Posts\CheckLanguageRule;

class UpdatePostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:posts,id,deleted_at,NULL',
            'translations' => ['required', 'array', 'min:1', 'max:3', new CheckLanguageRule()],
            'translations.*' => ['required', 'array', 'min:2', 'max:4'],
            'translations.*.title' => 'required|string|min:3|max:255',
            'translations.*.description' => 'required|string|min:1|max:65535',
            'translations.*.content' => 'required|string|min:1|max:65535',
            'tags' => 'nullable|array',
            'tags.*' => 'required|integer|exists:tags,id,deleted_at,NULL',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['id' => $this->route('news')]);
    }
}
