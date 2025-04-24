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
                'bidang_usaha' => 'sometimes|string',
                'provinsi' => 'sometimes|string',
                'kota' => 'sometimes|string',
                'instagram' => 'sometimes|string',
                'website' => 'sometimes|string',
                'linkedin' => 'sometimes|string',
            ];
        }
        return [
            'bidang_usaha' => 'required|string',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'instagram' => 'required|string',
            'website' => 'required|string',
            'linkedin' => 'required|string',
        ];
    }
}
