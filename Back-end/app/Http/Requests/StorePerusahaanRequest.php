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
            'telepon' => 'required|string',
            'deskripsi' => 'required|string',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'desa' => 'required|string',
            'alamat' => 'required|string',
            'kode_pos' => 'required|string',
            'telepon' => 'required|string',
            'website' => 'required|url',
            'instagram' => 'required|string',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'npwp' => 'required|image|mimes:png,jpeg,jpg|max:2048',
            'surat_legalitas' => 'required|image|mimes:png,jpeg,jpg|max:2048',
        ];
    }
}
