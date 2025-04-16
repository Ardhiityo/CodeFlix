<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Interface\UserDeviceService;
use Symfony\Component\HttpFoundation\Response;

class UserDeviceLimitMiddleware
{
    public function __construct(private UserDeviceService $userDeviceService) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->userDeviceService->getDeviceIdByUserSessionCurrent()) {

            if (!$this->userDeviceService->getCurrentDeviceFromSessionEqualsToUserDevice()) {
                return $this->userDeviceService->redirectRouteToLoginWithErrors();
            }

            $this->userDeviceService->updateLastActive();
        } else {

            if ($this->userDeviceService->checkUserDeviceLimit()) {
                return $this->userDeviceService->redirectRouteToLoginWithErrors();
            } else {
                $userDevice = $this->userDeviceService->createUserDevice();
                $this->userDeviceService->createDeviceIdSession($userDevice->device_id);
            }
        }

        return $next($request);
    }
}
