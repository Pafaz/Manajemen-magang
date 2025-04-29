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
                'divisi_header' => 'sometimes|image|mimes:png,jpg|max:2048',
                'kategori_proyek' => 'sometimes|array|min:1',
                'kategori_proyek*' => 'sometimes|string|max:50|distinct',    
            ];
        }
        return [
            'nama' => 'required|string|max:50|unique:divisi,nama',
            'divisi_header' => 'required|image|mimes:png,jpg|max:2048',
            'kategori_proyek' => 'required|array|min:1',
            'kategori_proyek*' => 'required|string|max:50|distinct',
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
