<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MentorRequest extends FormRequest
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
            'nama' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'telepon' => 'required|numeric|digits_between:10,12',
            'id_divisi' => 'required|exists:divisi,id',
            'profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
