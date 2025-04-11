<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SekolahRequest extends FormRequest
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
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|numeric|digits_between:10,12',
            'jurusan' => 'required|array',
            'jurusan.*' => 'string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama Sekolah harus diisi.',
            'alamat.required' => 'Alamat Sekolah harus diisi.',
            'telepon.required' => 'Telepon Sekolah harus diisi.',
            'nama.string' => 'Nama Sekolah harus berupa huruf.',
            'alamat.string' => 'Alamat Sekolah harus berupa huruf.',
            'nama.max' => 'Nama Sekolah tidak boleh lebih dari 50 karakter.',
            'alamat.max' => 'Alamat Sekolah tidak boleh lebih dari 255 karakter.',
            'telepon.digits_between' => 'Telepon Sekolah harus berupa angka dan terdiri dari 10 hingga 12 digit.',
            'telepon.numeric' => 'Telepon Sekolah harus berupa angka.',
        ];
    }
}
