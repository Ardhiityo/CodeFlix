<?php

namespace App\Services\Repository;

use App\Models\UserDevice;
use Illuminate\Support\Str;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\Auth;
use App\Services\Interface\UserDeviceService;

class UserDeviceRepository implements UserDeviceService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getUserCurrent()
    {
        return Auth::user();
    }

    public function getDeviceIdByUserSessionCurrent()
    {
        return session('device_id', false);
    }

    public function getCurrentDeviceFromSessionEqualsToUserDevice()
    {
        return $this->getUserCurrent()->userDevices()
            ->where('device_id', $this->getDeviceIdByUserSessionCurrent())
            ->exists();
    }

    public function checkUserDeviceLimit()
    {
        return $this->getUserCurrentTotalDevices() >= $this->getUserCurrentPlanByTotalMaxDevices();
    }

    public function getUserCurrentPlanByTotalMaxDevices()
    {
        return $this->getUserCurrent()->plans()->max('max_devices') ?? 1;
    }

    public function getUserCurrentTotalDevices()
    {
        return $this->getUserCurrent()->userDevices()->count();
    }

    public function redirectRouteToLoginWithErrors()
    {
        Auth::logout();
        return redirect()->route('login')->withErrors(['UserDevices' => 'Batas maksimum device telah tercapai']);
    }

    public function createUserDevice()
    {
        return  UserDevice::create([
            'user_id' => $this->getUserCurrent()->id,
            'device_name' => Agent::device(),
            'device_id' => Str::uuid(),
            'device_type' => Agent::deviceType(),
            'platform' => Agent::platform(),
            'platform_version' => Agent::version(Agent::platform()),
            'browser' => Agent::browser(),
            'browser_version' => Agent::version(Agent::browser()),
            'last_active' => now(),
            'is_active' => true
        ]);
    }

    public function updateLastActive()
    {
        return UserDevice::where('device_id', $this->getDeviceIdByUserSessionCurrent())
            ->first()
            ->update(['last_active' => now()]);
    }

    public function createDeviceIdSession(string $device_id)
    {
        return session(['device_id' => $device_id]);
    }
}
