<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    private UserService $UserService;

    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }

    public function register(RegisterRequest $request)
    {
        return $this->UserService->register($request->validated());
    }

    public function assignRole(Request $request, $role)
    {
        $request->validate([
            'id_user' => 'required|string|exists:users,id'
        ]);
        return $this->UserService->assignRole( $request, $role);
    }
}
