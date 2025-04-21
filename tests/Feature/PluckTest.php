<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Container\Attributes\Database;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PluckTest extends TestCase
{
    public function testPluck()
    {
        $this->seed(UserSeeder::class);

        $pluck = User::pluck('email');

        self::assertNotNull($pluck);

        Log::info($pluck);
    }
}
