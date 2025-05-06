<?php

namespace App\Http\Requests;


class IzinRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->isUpdate()) {
            return [
                'mulai' => 'sometimes|date',
                "selesai" => 'sometimes|date|after_or_equal:mulai',
                'deskripsi' => 'sometimes|string',
                'jenis' => 'sometimes|string',
                'bukti' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
                'status_izin' => 'sometimes|string',
            ];
        }
        return [
            'mulai' => 'required|date',
            "selesai" => 'required|date|after_or_equal:mulai',
            'deskripsi' => 'required|string',
            'jenis' => 'required|string',
            'bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
