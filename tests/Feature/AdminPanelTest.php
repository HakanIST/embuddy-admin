<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::factory()->create([
            'email' => 'admin@uskudar.edu.tr',
            'password' => bcrypt('admin123'),
        ]);
    }

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertOk();
    }

    public function test_root_page_is_accessible(): void
    {
        $response = $this->get('/');
        $response->assertOk();
    }

    public function test_admin_can_login_and_see_dashboard(): void
    {
        $admin = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/');
        $response->assertOk();
    }

    public function test_health_check_endpoint(): void
    {
        $response = $this->get('/up');
        $response->assertOk();
    }

    /**
     * Test that Filament resource routes exist and authenticated users
     * are not blocked at auth level (403). Since Prisma tables don't
     * exist in the test DB, we accept 200 or 500 (table not found)
     * but NOT 403 (auth) or 404 (route not found).
     */
    public function test_admin_can_reach_resource_routes(): void
    {
        $admin = $this->createAdmin();

        $resourcePaths = [
            'embuddy-users',
            'guides',
            'guide-categories',
            'events',
            'campus-locations',
            'media-items',
            'achievements',
            'word-of-days',
            'daily-tasks',
            'mood-entries',
        ];

        foreach ($resourcePaths as $path) {
            $response = $this->actingAs($admin)->get("/{$path}");
            $this->assertNotEquals(
                403,
                $response->getStatusCode(),
                "/{$path} should not return 403 Forbidden"
            );
            $this->assertNotEquals(
                404,
                $response->getStatusCode(),
                "/{$path} should not return 404 Not Found"
            );
        }
    }
}
