<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Cek apakah ini request create (POST)
     */
    public function isCreate(): bool
    {
        return $this->isMethod('post');
    }

    /**
     * Cek apakah ini request update (PUT/PATCH)
     */
    public function isUpdate(): bool
    {
        return $this->isMethod('put') || $this->isMethod('patch');
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'numeric' => ':attribute harus berupa angka.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'unique' => ':attribute sudah terdaftar.',
            'exists' => ':attribute tidak ditemukan.',
            'mimes:png,jpg,jpeg' => ':attribute harus berupa gambar dengan format JPEG, PNG, atau JPG.',
            'max:2048' => ':attribute tidak boleh lebih dari :max kilobytes.',
            
        ];
    }
}
