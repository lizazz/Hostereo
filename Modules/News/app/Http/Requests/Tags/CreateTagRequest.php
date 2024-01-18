<?php

namespace Modules\News\app\Http\Requests\Tags;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTagRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'required', 'min:2', 'max:255', Rule::unique('tags', 'name')->where(function ($query) {
                return $query->where('deleted_at', null);
            })]
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
