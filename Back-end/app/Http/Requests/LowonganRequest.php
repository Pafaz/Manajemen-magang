<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LowonganRequest extends BaseFormRequest
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
                'tanggal_mulai' => 'sometimes|date',
                'tanggal_selesai' => 'sometimes|date|after_or_equal:tanggal_mulai',
                'id_cabang' => 'sometimes|integer|exists:cabang,id',
                'id_divisi' => 'sometimes|integer|exists:divisi,id',
                'max_kuota' => 'sometimes|integer|min:1',
                'requirement' => 'sometimes|string',
                'jobdesc' => 'sometimes|string',
            ];
        }
        return [
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'id_cabang' => 'required|integer|exists:cabang,id',
            'id_divisi' => 'required|integer|exists:divisi,id',
            'max_kuota' => 'required|integer|min:1',
            'requirement' => 'string|required',
            'jobdesc' => 'string|required',
        ];
    }
}