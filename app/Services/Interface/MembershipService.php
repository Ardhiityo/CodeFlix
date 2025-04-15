<?php

namespace App\Services\Interface;

interface MembershipService
{
    public function createMembership(int $planId);
}
