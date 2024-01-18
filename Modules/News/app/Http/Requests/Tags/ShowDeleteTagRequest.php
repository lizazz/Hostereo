<?php

namespace Modules\News\app\Http\Requests\Tags;

use Illuminate\Foundation\Http\FormRequest;

class ShowDeleteTagRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:tags,id,deleted_at,NULL'
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
        $this->merge(['id' => $this->route('tag')]);
    }
}
