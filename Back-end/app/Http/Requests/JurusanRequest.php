<?php

namespace App\Http\Requests;


class JurusanRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|unique:jurusan,name',
            'id_sekolah' => 'required|uuid',
        ];
    }
}
