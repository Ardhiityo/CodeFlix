<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\Interface\MembershipService;
use App\Services\Interface\PlanService;
use App\Services\Interface\UserDeviceService;

class SubscribeController extends Controller
{

    public function __construct(
        private UserDeviceService $userDeviceService,
        private PlanService $planService,
        private MembershipService $membershipService
    ) {}

    public function showPlans()
    {
        $plans = $this->planService->getAllPlans();

        return view(
            'subscription.plans',
            compact('plans')
        );
    }

    public function checkoutPlan(Plan $plan)
    {
        return view(
            'subscription.checkout',
            compact('plan')
        );
    }

    public function processPlan(Plan $plan)
    {
        $this->membershipService->createMembership(planId: $plan->id);

        return view('subscription.success');
    }
}
