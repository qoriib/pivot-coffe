<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tableId = $this->route('table') ? $this->route('table')->id : null;

        return [
            'number' => 'required|integer|min:1|unique:cafe_tables,number' . ($tableId ? ',' . $tableId : ''),
        ];
    }

    public function messages(): array
    {
        return [
            'number.required' => 'Nomor meja wajib diisi.',
            'number.integer'  => 'Nomor meja harus berupa angka.',
            'number.unique'   => 'Nomor meja sudah digunakan.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $isEdit = $this->method() === 'PUT';
        throw new HttpResponseException(
            redirect()->route('admin.tables.index')
                ->withErrors($validator)
                ->withInput()
                ->with('open_modal', $isEdit ? 'modal-edit-table' : 'modal-create-table')
        );
    }
}
