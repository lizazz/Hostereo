<?php

namespace Modules\News\app\Http\Requests\PostTranslations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePostTranslationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $postId = $this->post_id;
        $languageId = $this->language_id;

        return [
            'post_id' => [
                'required',
                'integer',
                'exists:posts,id,deleted_at,NULL',
                Rule::unique('post_translations')->where(function ($query) use($postId,$languageId) {
                    return $query->where('post_id', $postId)
                        ->where('language_id', $languageId);
                })],
            'language_id' => 'required|integer|exists:languages,id',
            'tags' => 'nullable|array',
            'tags.*' => 'required|integer|exists:tags,id,deleted_at,NULL',
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|min:1|max:65535',
            'content' => 'required|string|min:1|max:65535',
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
