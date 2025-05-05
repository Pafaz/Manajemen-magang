<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MentorRequest extends BaseFormRequest
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
        $mentorId = $this->route('mentor');
        if ($this->method() === 'PUT') {
            return [
                'nama' => 'sometimes|string',
                'email' => 'sometimes|email|max:255|unique:users,email' . $mentorId,
                'password' => 'sometimes|string',
                'telepon' => 'sometimes|numeric|digits_between:10,12|unique:users,telepon' . $mentorId,
                'id_divisi' => 'sometimes|exists:divisi,id',
                'profile' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
                'cover' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048'
            ];
        }

        return [
            'nama' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'telepon' => 'required|numeric|digits_between:10,12|unique:users,telepon',
            'id_divisi' => 'required|exists:divisi,id',
            'profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'cover' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}