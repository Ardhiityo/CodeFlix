<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Interface\UserDeviceService;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

class AuthController extends Controller
{
    public function __construct(private UserDeviceService $userDeviceService) {}

    public function logout(Request $request)
    {
        $this->userDeviceService->removeDeviceIdBySession();
        return app(AuthenticatedSessionController::class)->destroy($request);
    }
}
