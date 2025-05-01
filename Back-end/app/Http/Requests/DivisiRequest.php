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
        if($this->isUpdate()){
            return [
                'nama' => 'sometimes|string|max:50|unique:divisi,nama',
                'kategori_proyek' => 'sometimes|array|min:1',
                'kategori_proyek.*' => 'sometimes|string|max:50|distinct',    
                'foto_cover' => 'sometimes|image|mimes:png,jpg|max:2048',
            ];
        }
        return [
            'nama' => 'required|string|max:50|unique:divisi,nama',
            'kategori_proyek' => 'required|array|min:1',
            'kategori_proyek.*' => 'required|string|max:50|distinct',
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
