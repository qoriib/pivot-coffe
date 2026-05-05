<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama kategori wajib diisi.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $isEdit = $this->method() === 'PUT';
        throw new HttpResponseException(
            redirect()->route('admin.categories.index')
                ->withErrors($validator)
                ->withInput()
                ->with('open_modal', $isEdit ? 'modal-edit-category' : 'modal-create-category')
        );
    }
}
