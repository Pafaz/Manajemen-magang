<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MagangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

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

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'date' => ':attribute harus berupa tanggal.',
            'string' => ':attribute harus berupa teks.',
        ];
    }
}
