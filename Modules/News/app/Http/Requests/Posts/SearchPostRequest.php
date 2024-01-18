<?php

namespace Modules\News\app\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchPostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'languages' => 'nullable|array|min:1|max:3',
            'languages.*' => 'string|size:2|exists:languages,prefix',
            'tags' => 'nullable|array',
            'tags.*' => 'required|exists:tags,name,deleted_at,NULL',
            'title' => 'nullable|string|min:3|max:255',
            'description' => 'nullable|string|min:3|max:65535',
            'content' => 'nullable|string|min:3|max:65535',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
