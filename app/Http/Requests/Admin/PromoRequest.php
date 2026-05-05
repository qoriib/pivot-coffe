<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PromoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $promoId = $this->route('promo') ? $this->route('promo')->id : null;

        return [
            'code'           => 'required|string|max:50|unique:promos,code' . ($promoId ? ',' . $promoId : ''),
            'description'    => 'required|string|max:255',
            'discount_type'  => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'is_active'      => 'nullable|boolean',
            'valid_from'     => 'required|date',
            'valid_until'    => 'required|date|after_or_equal:valid_from',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required'              => 'Kode promo wajib diisi.',
            'code.unique'                => 'Kode promo sudah digunakan.',
            'description.required'       => 'Deskripsi wajib diisi.',
            'discount_type.required'     => 'Tipe diskon wajib dipilih.',
            'discount_value.required'    => 'Nilai diskon wajib diisi.',
            'valid_from.required'        => 'Tanggal mulai wajib diisi.',
            'valid_until.required'       => 'Tanggal berakhir wajib diisi.',
            'valid_until.after_or_equal' => 'Tanggal berakhir harus setelah atau sama dengan tanggal mulai.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $isEdit = $this->method() === 'PUT';
        throw new HttpResponseException(
            redirect()->route('admin.promos.index')
                ->withErrors($validator)
                ->withInput()
                ->with('open_modal', $isEdit ? 'modal-edit-promo' : 'modal-create-promo')
        );
    }
}
