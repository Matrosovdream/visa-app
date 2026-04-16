<?php

namespace Tests\Feature\Api\V1\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Verifies the auth + hasRole:admin,manager gate on /api/v1/admin/*.
 *
 * Admin API uses the web guard (session auth), so we use actingAs($user)
 * without a second argument.
 */
class AdminGateTest extends AdminTestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_hit_admin_me(): void
    {
        $response = $this->getJson('/api/v1/admin/me');

        // 'auth' middleware on the web guard returns 401 for JSON requests.
        $response->assertStatus(401);
    }

    public function test_regular_user_is_blocked_by_hasrole(): void
    {
        // hasRole middleware redirects to web.index on failure, so we expect a 302.
        $response = $this->actingAs($this->regularUser())
            ->getJson('/api/v1/admin/me');

        $this->assertContains($response->status(), [302, 403],
            'Non-admin users must not be able to reach admin endpoints.');
    }

    public function test_admin_can_access_me(): void
    {
        $response = $this->actingAs($this->admin())
            ->getJson('/api/v1/admin/me');

        $response->assertOk()->assertJsonStructure(['data' => ['id', 'name', 'email']]);
    }

    public function test_manager_can_access_me(): void
    {
        $response = $this->actingAs($this->manager())
            ->getJson('/api/v1/admin/me');

        $response->assertOk();
    }

    public function test_admin_can_fetch_stats(): void
    {
        $response = $this->actingAs($this->admin())
            ->getJson('/api/v1/admin/stats');

        $response->assertOk()
            ->assertJsonStructure(['data' => [
                'users', 'orders', 'orders_paid', 'products', 'articles', 'countries',
            ]]);
    }
}
