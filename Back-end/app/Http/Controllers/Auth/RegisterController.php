<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    private UserService $UserService;

    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }

    public function registerPeserta(RegisterRequest $request)
    {
        // Log::info( $request->all());
        return $this->UserService->register($request->validated(), 'peserta');
    }

    public function registerPerusahaan(RegisterRequest $request)
    {
        return $this->UserService->register($request->validated(), 'perusahaan');
    }
}
