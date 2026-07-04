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
        $response = $this->get('/admin/login');
        $response->assertOk();
    }

    public function test_admin_can_login_and_see_dashboard(): void
    {
        $admin = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertOk();
    }

    public function test_health_check_endpoint(): void
    {
        $response = $this->get('/up');
        $response->assertOk();
    }

    public function test_admin_can_access_student_list(): void
    {
        $admin = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin/embuddy-users');
        $response->assertOk();
    }

    public function test_admin_can_access_guides_page(): void
    {
        $admin = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin/guides');
        $response->assertOk();
    }

    public function test_admin_can_access_guide_categories_page(): void
    {
        $admin = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin/guide-categories');
        $response->assertOk();
    }

    public function test_admin_can_access_events_page(): void
    {
        $admin = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin/events');
        $response->assertOk();
    }

    public function test_admin_can_access_campus_locations_page(): void
    {
        $admin = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin/campus-locations');
        $response->assertOk();
    }

    public function test_admin_can_access_media_items_page(): void
    {
        $admin = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin/media-items');
        $response->assertOk();
    }

    public function test_admin_can_access_achievements_page(): void
    {
        $admin = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin/achievements');
        $response->assertOk();
    }

    public function test_admin_can_access_word_of_day_page(): void
    {
        $admin = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin/word-of-days');
        $response->assertOk();
    }

    public function test_admin_can_access_daily_tasks_page(): void
    {
        $admin = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin/daily-tasks');
        $response->assertOk();
    }

    public function test_admin_can_access_mood_entries_page(): void
    {
        $admin = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin/mood-entries');
        $response->assertOk();
    }

    public function test_unauthenticated_user_is_redirected(): void
    {
        $response = $this->get('/admin/embuddy-users');
        $response->assertRedirect('/admin/login');
    }
}
