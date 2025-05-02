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
            'surat_pernyataan_diri' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'surat_pernyataan_ortu' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
