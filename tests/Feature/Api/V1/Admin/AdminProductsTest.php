<?php

namespace Tests\Feature\Api\V1\Admin;

use App\Models\Product\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminProductsTest extends AdminTestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_products(): void
    {
        Product::create(['name' => 'Visa A', 'slug' => 'visa-a', 'price' => 100]);
        Product::create(['name' => 'Visa B', 'slug' => 'visa-b', 'price' => 200]);

        $response = $this->actingAs($this->admin())->getJson('/api/v1/admin/products');

        $response->assertOk()->assertJsonStructure(['data']);
        $this->assertGreaterThanOrEqual(2, count($response->json('data')));
    }

    public function test_admin_can_create_product(): void
    {
        $response = $this->actingAs($this->admin())->postJson('/api/v1/admin/products', [
            'name'  => 'Tourist Visa',
            'price' => 150.0,
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'Tourist Visa')
            ->assertJsonPath('data.slug', 'tourist-visa');

        $this->assertDatabaseHas('products', ['slug' => 'tourist-visa']);
    }

    public function test_store_generates_unique_slug_on_collision(): void
    {
        Product::create(['name' => 'Tourist Visa', 'slug' => 'tourist-visa', 'price' => 100]);

        $response = $this->actingAs($this->admin())->postJson('/api/v1/admin/products', [
            'name'  => 'Tourist Visa',
            'price' => 200,
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.slug', 'tourist-visa-2');
    }

    public function test_store_validates_name_and_price(): void
    {
        $response = $this->actingAs($this->admin())->postJson('/api/v1/admin/products', []);

        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'price']);
    }

    public function test_admin_can_show_product(): void
    {
        $product = Product::create(['name' => 'Visa X', 'slug' => 'visa-x', 'price' => 100]);

        $response = $this->actingAs($this->admin())
            ->getJson("/api/v1/admin/products/{$product->id}");

        $response->assertOk()->assertJsonPath('data.id', $product->id);
    }

    public function test_admin_can_update_product(): void
    {
        $product = Product::create(['name' => 'Visa Old', 'slug' => 'visa-old', 'price' => 100]);

        $response = $this->actingAs($this->admin())
            ->putJson("/api/v1/admin/products/{$product->id}", [
                'name'  => 'Visa New',
                'price' => 250,
            ]);

        $response->assertOk()->assertJsonPath('data.name', 'Visa New');
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Visa New']);
    }

    public function test_admin_can_delete_product(): void
    {
        $product = Product::create(['name' => 'Goner', 'slug' => 'goner', 'price' => 10]);

        $response = $this->actingAs($this->admin())
            ->deleteJson("/api/v1/admin/products/{$product->id}");

        $response->assertOk()->assertJson(['message' => 'Product deleted.']);
    }
}
