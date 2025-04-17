<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSekolahRequest extends FormRequest
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
            'nama' => 'required|string|max:255',
            'telepon' => 'required|numeric|digits_between:10,12',
            'alamat' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute harus diisi.',
            'string' => ':attribute harus berupa huruf.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'numeric' => ':attribute harus berupa angka.',
            'digits_between' => ':attribute harus terdiri dari :min hingga :max digit.',
        ];
    }
}
