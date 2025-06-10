<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PiketRequest extends BaseFormRequest
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
                "shift"=> "sometimes|in:pagi,sore",
                "hari"=> "sometimes|in:senin,selasa,rabu,kamis,jumat,sabtu",
                'peserta' => 'sometimes|array|min:1',
                'peserta.*' => 'sometimes|string|max:50|distinct',
            ];
        }
        return [
            "shift"=> "required|in:pagi,sore",
            "hari"=> "required|in:senin,selasa,rabu,kamis,jumat,sabtu",
            'peserta' => 'required|array|min:1',
            'peserta.*' => 'required|string|max:50|distinct',
        ];
    }
}
