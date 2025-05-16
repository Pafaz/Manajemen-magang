<?php

namespace App\Http\Requests;


class DivisiRequest extends BaseFormRequest
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
                'nama' => 'sometimes|string|max:50',
                'kategori_proyek' => 'sometimes|array|min:1',
                'kategori_proyek.*.nama' => 'sometimes|string|max:50|distinct',
                'kategori_proyek.*.urutan' => 'sometimes|integer|min:1',
                'foto_cover' => 'sometimes|image|mimes:png,jpg|max:2048',
            ];
        }

        return [
            'nama' => 'required|string|max:50',
            'kategori_proyek' => 'required|array|min:1',
            'kategori_proyek.*.nama' => 'required|string|max:50|distinct',
            'kategori_proyek.*.urutan' => 'required|integer|min:1',
            'foto_cover' => 'required|image|mimes:png,jpg|max:2048',
        ];
    }


    public function messages(): array
    {
        return array_merge(parent::messages(),[
            'array' => ':attribute harus valid.',
            'distinct' => ':attribute tidak boleh duplikat'
        ]);
    }
}
