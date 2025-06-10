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
        // if($this->isUpdate()){
        //     return [
        //         'status' => 'required|string',
        //         'no_surat' => 'required|string'
        //     ];
        // }
        return [
            'id_lowongan' => 'required|numeric',
            'mulai' => 'required|date',
            'selesai' => 'required|date|after:mulai',
            'surat_pernyataan_diri' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
        ];
    }
}
