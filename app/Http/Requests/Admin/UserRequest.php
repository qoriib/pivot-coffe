<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $adminId = $this->route('user') ? $this->route('user')->id : null;
        $isEdit  = $this->method() === 'PUT';

        return [
            'name'                  => 'required|string|max:100',
            'email'                 => 'required|email|unique:admins,email' . ($adminId ? ',' . $adminId : ''),
            'role'                  => 'required|in:superadmin,admin,kasir',
            'password'              => $isEdit ? 'nullable|string|min:6|confirmed' : 'required|string|min:6|confirmed',
            'password_confirmation' => $isEdit ? 'nullable' : 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan.',
            'role.required'      => 'Role wajib dipilih.',
            'role.in'            => 'Role tidak valid.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $isEdit = $this->method() === 'PUT';
        throw new HttpResponseException(
            redirect()->route('admin.users.index')
                ->withErrors($validator)
                ->withInput()
                ->with('open_modal', $isEdit ? 'modal-edit-user' : 'modal-create-user')
        );
    }
}
