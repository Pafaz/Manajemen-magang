<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePerusahaanRequest extends FormRequest
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
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'alamat' => 'required|string',
            'bidang_usaha' => 'required|string',
            'kode_pos' => 'required|string',
            'website' => 'required|url',
            'instagram' => 'required|string',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'npwp' => 'required|image|mimes:png,jpeg,jpg|max:2048',
            'surat_legalitas' => 'required|image|mimes:png,jpeg,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'url' => ':attribute harus berupa URL.',
            'image' => ':attribute harus berupa gambar.',
            'mimes' => ':attribute harus berupa gambar dengan format JPEG, PNG, atau JPG.',
            'max' => ':attribute tidak boleh lebih dari :max kilobytes.',
        ];
    }
}
