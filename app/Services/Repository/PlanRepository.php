<?php

namespace App\Services\Repository;

use App\Models\Plan;
use App\Services\Interface\PlanService;

class PlanRepository implements PlanService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllPlans()
    {
        return Plan::all();
    }
}
