<?php

namespace Tests\Feature\Api\V1\Admin;

use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AdminUsersTest extends AdminTestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_users(): void
    {
        $admin = $this->admin();
        User::factory()->count(3)->create();

        $response = $this->actingAs($admin)->getJson('/api/v1/admin/users');

        $response->assertOk()->assertJsonStructure(['data']);
        $this->assertGreaterThanOrEqual(4, count($response->json('data')));
    }

    public function test_admin_can_show_user(): void
    {
        $admin = $this->admin();
        $target = $this->regularUser();

        $response = $this->actingAs($admin)
            ->getJson("/api/v1/admin/users/{$target->id}");

        $response->assertOk()
            ->assertJsonPath('data.id', $target->id)
            ->assertJsonPath('data.email', $target->email)
            ->assertJsonPath('data.has_pin', false);
    }

    public function test_show_returns_404_for_missing_user(): void
    {
        $response = $this->actingAs($this->admin())
            ->getJson('/api/v1/admin/users/999999');

        $response->assertStatus(404);
    }

    public function test_admin_can_create_user(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->postJson('/api/v1/admin/users', [
            'name'      => 'New Member',
            'email'     => 'new@example.com',
            'password'  => 'password123',
            'role_id'   => $this->userRole->id,
            'is_active' => true,
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.email', 'new@example.com');

        $this->assertDatabaseHas('users', ['email' => 'new@example.com']);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin())->postJson('/api/v1/admin/users', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password', 'role_id']);
    }

    public function test_store_rejects_duplicate_email(): void
    {
        User::factory()->create(['email' => 'dupe@example.com']);

        $response = $this->actingAs($this->admin())->postJson('/api/v1/admin/users', [
            'name'     => 'Dupe',
            'email'    => 'dupe@example.com',
            'password' => 'password123',
            'role_id'  => $this->userRole->id,
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['email']);
    }

    public function test_admin_can_update_user(): void
    {
        $target = $this->regularUser();

        $response = $this->actingAs($this->admin())
            ->putJson("/api/v1/admin/users/{$target->id}", [
                'name' => 'Renamed',
            ]);

        $response->assertOk()->assertJsonPath('data.name', 'Renamed');
        $this->assertDatabaseHas('users', ['id' => $target->id, 'name' => 'Renamed']);
    }

    public function test_admin_cannot_delete_themselves(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)
            ->deleteJson("/api/v1/admin/users/{$admin->id}");

        $response->assertStatus(422);
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_can_delete_another_user(): void
    {
        $target = $this->regularUser();

        $response = $this->actingAs($this->admin())
            ->deleteJson("/api/v1/admin/users/{$target->id}");

        $response->assertOk()->assertJson(['message' => 'User deleted.']);
        $this->assertDatabaseMissing('users', ['id' => $target->id]);
    }

    public function test_admin_can_update_password(): void
    {
        $target = $this->regularUser();

        $response = $this->actingAs($this->admin())
            ->putJson("/api/v1/admin/users/{$target->id}/password", [
                'password' => 'brand-new-password',
            ]);

        $response->assertOk();
        $this->assertTrue(Hash::check('brand-new-password', $target->fresh()->password));
    }

    public function test_update_password_validates_min_length(): void
    {
        $target = $this->regularUser();

        $response = $this->actingAs($this->admin())
            ->putJson("/api/v1/admin/users/{$target->id}/password", [
                'password' => 'abc',
            ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['password']);
    }

    public function test_admin_can_set_pin(): void
    {
        $target = $this->regularUser();

        $response = $this->actingAs($this->admin())
            ->putJson("/api/v1/admin/users/{$target->id}/pin", [
                'pin' => '12345',
            ]);

        $response->assertOk()->assertJson(['message' => 'PIN updated.']);
        $this->assertNotNull($target->fresh()->pin);
    }

    public function test_admin_can_clear_pin_by_sending_empty(): void
    {
        $target = $this->regularUser();
        $target->forceFill(['pin' => Hash::make('11111')])->saveQuietly();

        $response = $this->actingAs($this->admin())
            ->putJson("/api/v1/admin/users/{$target->id}/pin", []);

        $response->assertOk()->assertJson(['message' => 'PIN removed.']);
        $this->assertNull($target->fresh()->pin);
    }
}
