<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class BaseService
{
    protected function getAuthenticatedUser()
    {
        return Auth::guard('sanctum')->user();
    }
}