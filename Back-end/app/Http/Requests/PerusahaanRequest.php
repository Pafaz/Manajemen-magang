<?php

namespace App\Http\Requests;

class PerusahaanRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isUpdate()) {
            return [
                'nama' => 'required|string',
                'telepon' => 'required|numeric|digits_between:10,12|unique:users,telepon',
                'deskripsi' => 'required|string',
                'provinsi' => 'required|string',
                'kota' => 'required|string',
                'alamat' => 'required|string',
                'bidang_usaha' => 'required|string',
                'kode_pos' => 'required|string',
                'website' => 'required|url',
                'instagram' => 'required|string',
                'logo' => 'image|mimes:jpeg,png,jpg|max:2048',
                'npwp' => 'image|mimes:png,jpeg,jpg|max:2048',
                'surat_legalitas' => 'image|mimes:png,jpeg,jpg|max:2048',
            ];
        }

        return [
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
            'telepon' => 'required|numeric|digits_between:10,12|unique:users,telepon',
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
        return array_merge(parent::messages(), [
            'url' => 'Format url tidak valid.'
        ]);
    }
}
