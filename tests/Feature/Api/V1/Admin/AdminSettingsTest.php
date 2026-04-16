<?php

namespace Tests\Feature\Api\V1\Admin;

use App\Models\Content\SiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminSettingsTest extends AdminTestCase
{
    use RefreshDatabase;

    public function test_admin_can_fetch_settings(): void
    {
        $response = $this->actingAs($this->admin())->getJson('/api/v1/admin/settings');

        $response->assertOk()->assertJsonStructure(['data']);
    }

    public function test_admin_can_bulk_update_settings(): void
    {
        $response = $this->actingAs($this->admin())->putJson('/api/v1/admin/settings', [
            'settings' => [
                'sitename' => 'Visa App',
                'phone'    => '+1 555 0123',
            ],
        ]);

        $response->assertOk()->assertJson(['message' => 'Settings updated.']);

        $this->assertDatabaseHas('site_settings', ['key' => 'sitename', 'value' => 'Visa App']);
        $this->assertDatabaseHas('site_settings', ['key' => 'phone', 'value' => '+1 555 0123']);
    }

    public function test_update_requires_settings_array(): void
    {
        $response = $this->actingAs($this->admin())->putJson('/api/v1/admin/settings', []);

        $response->assertStatus(422)->assertJsonValidationErrors(['settings']);
    }
}
