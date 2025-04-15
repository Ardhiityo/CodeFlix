<?php

namespace App\Services\Interface;

interface UserDeviceService
{
    public function getUserCurrent();
    public function getDeviceIdByUserSessionCurrent();
    public function getCurrentDeviceFromSessionEqualsToUserDevice();
    public function getUserCurrentPlanByTotalMaxDevices();
    public function getUserCurrentTotalDevices();
    public function redirectRouteToLoginWithErrors();
    public function createUserDevice();
    public function checkUserDeviceLimit();
    public function updateLastActive();
    public function createDeviceIdSession(string $device_id);
}
