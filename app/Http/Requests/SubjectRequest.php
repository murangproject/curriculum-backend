<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', Rule::unique('subjects', 'code')->ignore($this->code, 'code')],
            'title' => 'required|string',
            'description' => 'nullable|string',
            'units' => 'required|integer',
            'hours' => 'required|integer',
            'year_level' => 'required|integer',
            'term' => 'required|integer',
            'syllabus' => 'nullable|string',
            'prerequisite_code' => 'nullable|string',
            'corequisite_code' => 'nullable|string',
        ];
    }
}
