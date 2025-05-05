<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    private UserService $UserService;

    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }
    
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        return $this->UserService->sendOtp($request);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        return $this->UserService->verifyOtp($request);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        return $this->UserService->updatePasswordWithOtp($request);
    }
}
