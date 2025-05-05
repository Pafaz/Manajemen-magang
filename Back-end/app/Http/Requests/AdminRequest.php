<?php

namespace App\Http\Requests;

use App\Models\Admin_cabang;
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
        $adminId = $this->route('admin');
    
        $userId = null;
        if ($adminId && $this->method() === 'PUT') {
            $admin = Admin_cabang::with('user')->find($adminId);
            $userId = $admin?->user?->id;
        }
    
        if ($this->method() === 'PUT') {
            return [
                'nama' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:users,email,' . $userId,
                'password' => 'sometimes|string',
                'telepon' => 'sometimes|numeric|digits_between:10,12|unique:users,telepon,' . $userId,
                'profile' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
                'cover' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            ];
        }
    
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'sometimes|string',
            'telepon' => 'required|numeric|digits_between:10,12|unique:users,telepon',
            'profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'cover' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
    
}