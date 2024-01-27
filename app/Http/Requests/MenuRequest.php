<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'linkable_type' => 'required',
            'linkable_id' => 'required_without:link',
            'link' => [
                'required_without:linkable_id',
                'nullable',
                'url',
            ],
            'new_tab' => 'required',
            'status' => 'required'
        ];
    }
}
