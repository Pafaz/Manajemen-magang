<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordController extends Controller
{
    //

    private UserService $UserService;
    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    } 

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
        ]);

        return $this->UserService->UpdatePassword($request->all());
    }
}