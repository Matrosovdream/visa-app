<?php

namespace Tests\Feature\Api\V1;

use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['title' => 'User', 'slug' => 'user', 'is_default' => true]);
    }

    public function test_authenticated_user_can_get_account(): void
    {
        $user = User::factory()->create();
        $user->roles()->attach(Role::first()->id);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/account');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_unauthenticated_user_cannot_get_account(): void
    {
        $response = $this->getJson('/api/v1/account');

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_get_settings(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/account/settings');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_authenticated_user_can_update_settings(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->putJson('/api/v1/account/settings', [
                'name' => 'Updated Name',
            ]);

        $response->assertOk();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_authenticated_user_can_update_email(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->putJson('/api/v1/account/settings', [
                'email' => 'newemail@example.com',
            ]);

        $response->assertOk();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'newemail@example.com',
        ]);
    }

    public function test_update_settings_validates_email_uniqueness(): void
    {
        $existingUser = User::factory()->create(['email' => 'taken@example.com']);
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->putJson('/api/v1/account/settings', [
                'email' => 'taken@example.com',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_unauthenticated_user_cannot_update_settings(): void
    {
        $response = $this->putJson('/api/v1/account/settings', [
            'name' => 'Updated Name',
        ]);

        $response->assertStatus(401);
    }
}
