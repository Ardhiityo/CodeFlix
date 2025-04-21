<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ExampleTest extends TestCase
{
    public function testPluck()
    {
        $pluck = User::pluck('email', 'name');

        self::assertNotNull($pluck);

        Log::info($pluck);
    }
}
