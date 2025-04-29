<?php

namespace App\Http\Requests;


class CabangRequest extends BaseFormRequest
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
                'bidang_usaha' => 'sometimes|string',
                'provinsi' => 'sometimes|string',
                'kota' => 'sometimes|string',
                'logo' => 'sometimes|image|mimes:png,jpeg,jpg|max:2048',
                'profil_background' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            ];
        }
        return [
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'logo' => 'required|image|mimes:png,jpeg,jpg|max:2048',
            'profil_background' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}