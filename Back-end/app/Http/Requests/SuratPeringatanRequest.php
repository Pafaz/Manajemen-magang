<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuratPeringatanRequest extends BaseFormRequest
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
                // "id_peserta" => "sometimes|string|exists:peserta,id",
                "keterangan_surat" => "sometimes|in:SP1,SP2,SP3",
                "alasan"=> "sometimes|string",
            ];
        }
        return [
            "id_peserta" => "required|string|exists:peserta,id",
            "keterangan_surat" => "required|in:SP1,SP2,SP3",
            "alasan"=> "required|string",
        ];
    }
}
