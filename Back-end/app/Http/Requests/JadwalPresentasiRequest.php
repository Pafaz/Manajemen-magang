<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JadwalPresentasiRequest extends BaseFormRequest
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
        if ($this->isUpdate()) {
            return [
                'kuota' => 'sometimes|integer|min:1',
                'lokasi'=> 'nullable|string',
                'link_zoom' => 'nullable|url',
                'tanggal' => 'sometimes|date|after:yesterday',
                'waktu_mulai' => 'sometimes|date_format:H:i',
                'waktu_selesai' => 'sometimes|date_format:H:i|after:waktu_mulai',
                'tipe' => 'sometimes|in:offline,online',
            ];
        }
        return [
            'kuota' => 'required|integer|min:1',
            'lokasi'=> 'nullable|string',
            'link_zoom' => 'nullable|url',
            'tanggal' => 'required|date|after:yesterday',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'tipe' => 'required|in:offline,online',
        ];
    }
}