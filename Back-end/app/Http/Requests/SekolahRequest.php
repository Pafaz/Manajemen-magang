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
        if ($this->isUpdate()) {
            return [
                'nama' => 'required|string|max:50|unique:sekolah,nama',
                'alamat' => 'required|string|max:255',
                'telepon' => 'required|numeric|digits_between:10,12',
            ];
        }

        return [
            'nama' => 'required|string|max:50|unique:sekolah,nama',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|numeric|digits_between:10,12',
            'jurusan' => 'required|array',
            'jurusan.*' => 'string|max:50|distinct',
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
