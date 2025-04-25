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
                'nama' => 'sometimes|string',
                'telepon' => 'sometimes|numeric|digits_between:10,12|unique:users,telepon',
                'deskripsi' => 'sometimes|string',
                'provinsi' => 'sometimes|string',
                'kota' => 'sometimes|string',
                'kecamatan' => 'sometimes|string',
                'alamat' => 'sometimes|string',
                'bidang_usaha' => 'sometimes|string',
                'kode_pos' => 'sometimes|string',
                'website' => 'sometimes|url',
                'tanggal_berdiri' => 'sometimes|date',
                'nama_penanggung_jawab' => 'sometimes|string',
                'nomor_penanggung_jawab' => 'sometimes|numeric|digits_between:10,12',
                'email_penanggung_jawab' => 'sometimes|email',
                'jabatan_penanggung_jawab' => 'sometimes|string',
                'logo' => 'sometimes|mimes:jpeg,png,jpg|max:2048',
                'npwp' => 'sometimes|mimes:png,jpeg,jpg|max:2048',
                'surat_legalitas' => 'sometimes|mimes:png,jpeg,jpg|max:2048',
            ];
        }

        return [
            'nama_penanggung_jawab' => 'required|string',
            'nomor_penanggung_jawab' => 'required|numeric|digits_between:10,12',
            'email_penanggung_jawab' => 'required|email',
            'jabatan_penanggung_jawab' => 'required|string',
            'tanggal_berdiri' => 'required|date',
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
            'telepon' => 'required|numeric|digits_between:10,12|unique:users,telepon',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'alamat' => 'required|string',
            'bidang_usaha' => 'required|string',
            'kode_pos' => 'required|string',
            'website' => 'required|url',
            'logo' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            'npwp' => 'nullable|mimes:png,jpeg,jpg|max:2048',
            'surat_legalitas' => 'nullable|mimes:png,jpeg,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), [
            'url' => 'Format url tidak valid.'
        ]);
    }
}
