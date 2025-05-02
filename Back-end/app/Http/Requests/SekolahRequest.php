<?php

namespace App\Http\Requests;

class SekolahRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->method() == 'PUT') {
            return [
                'nama' => 'sometimes|string|max:50|unique:sekolah,nama,' . $this->route('mitra'),
                'alamat' => 'sometimes|string|max:255',
                'telepon' => 'sometimes|numeric|digits_between:10,12|unique:sekolah,telepon',
                'jenis_institusi' => 'sometimes|string|max:50',
                'website' => 'nullable|url',
                'jurusan' => 'sometimes|array|min:1',
                'jurusan.*' => 'sometimes|string|max:50|distinct',
                'foto_header' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
                'id_cabang' => 'sometimes|string|max:50|exists:cabang,id',
            ];
        }

        return [
            'nama' => 'required|string|max:50|unique:sekolah,nama',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|numeric|digits_between:10,12|unique:sekolah,telepon',
            'jenis_institusi' => 'required|string|max:50',
            'website' => 'nullable|url',
            'jurusan' => 'required|array',
            'jurusan.*' => 'required|string|max:50|distinct',
            'foto_header' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'id_cabang' => 'required|string|max:50|exists:cabang,id',
        ];
    }

    public function messages () : array {
        return array_merge(parent::messages(), [
            'jurusan.required' => 'Minimal harus ada 1 jurusan.',
            'jurusan.array' => 'Format jurusan tidak valid.',
            'jurusan.*.string' => 'Setiap jurusan harus berupa teks.',
            'jurusan.*.max' => 'Setiap jurusan maksimal 50 karakter.',
            'jurusan.*.distinct' => 'Jurusan tidak boleh duplikat.',
        ]);
    }
}
