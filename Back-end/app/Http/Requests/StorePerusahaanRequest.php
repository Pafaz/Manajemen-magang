<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePerusahaanRequest extends FormRequest
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
            'id_user' => 'required|exists:users,id',
            'deskripsi' => 'required|string',
            'alamat' => 'required|string',
            'website' => 'required|url',
            'instagram' => 'required|string',
            'is_premium' => 'required|boolean',
            'is_active' => 'required|boolean',
        ];
    }
}
