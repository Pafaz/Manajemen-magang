<?php

namespace App\Http\Requests;


class MagangRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mulai' => 'required|date',
            'selesai' => 'required|date',
            'tipe' => 'required|string',
            'id_divisi_cabang' => 'required|id',
        ];
    }
}
