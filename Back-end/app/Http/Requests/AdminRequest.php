<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends BaseFormRequest
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
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255',
                'telepon' => 'sometimes|string',
                'id_cabang' => 'sometimes|integer|exists:cabang,id',
                'profile' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
                'header' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            ];
        }
        // dd($this->all(), $this->file());

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'telepon' => 'required|string',
            'id_cabang' => 'required|integer|exists:cabang,id',
            'profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'header' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}