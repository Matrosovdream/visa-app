<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Product\ProductRepo;
use App\Models\Product\Product;

class ProductRepoTest extends TestCase
{
    use RefreshDatabase;

    private ProductRepo $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = new ProductRepo();
    }

    public function test_create_product(): void
    {
        $result = $this->repo->create([
            'name' => 'Test Visa',
            'slug' => 'test-visa',
            'description' => 'A test visa product',
            'price' => 50,
        ]);

        $this->assertNotNull($result);
        $this->assertEquals('Test Visa', $result['name']);
        $this->assertArrayHasKey('Model', $result);
    }

    public function test_get_by_id(): void
    {
        $product = Product::create([
            'name' => 'Find Product',
            'slug' => 'find-product',
            'description' => 'Find me',
            'price' => 100,
        ]);

        $result = $this->repo->getByID($product->id);

        $this->assertNotNull($result);
        $this->assertEquals('Find Product', $result['name']);
    }

    public function test_update_product(): void
    {
        $product = Product::create([
            'name' => 'Original Product',
            'slug' => 'original-product',
            'description' => 'Original',
            'price' => 75,
        ]);

        $result = $this->repo->update($product->id, ['description' => 'Updated description']);

        $this->assertNotNull($result);
        $this->assertEquals('Updated description', $result['description']);
    }

    public function test_delete_product(): void
    {
        $product = Product::create([
            'name' => 'Delete Product',
            'slug' => 'delete-product',
            'description' => 'To delete',
            'price' => 25,
        ]);

        $deleted = $this->repo->delete($product->id);
        $this->assertTrue($deleted);
    }

    public function test_mapitem_returns_correct_keys(): void
    {
        $product = Product::create([
            'name' => 'Keys Product',
            'slug' => 'keys-product',
            'description' => 'Testing keys',
            'price' => 50,
        ]);

        $result = $this->repo->getByID($product->id);

        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('slug', $result);
        $this->assertArrayHasKey('description', $result);
        $this->assertArrayHasKey('price', $result);
        $this->assertArrayHasKey('offers', $result);
        $this->assertArrayHasKey('extras', $result);
        $this->assertArrayHasKey('Model', $result);
    }

    public function test_get_all_paginated(): void
    {
        Product::create(['name' => 'P1', 'slug' => 'p1', 'description' => 'D1', 'price' => 10]);
        Product::create(['name' => 'P2', 'slug' => 'p2', 'description' => 'D2', 'price' => 20]);

        $result = $this->repo->getAll([], 10);

        $this->assertArrayHasKey('items', $result);
        $this->assertGreaterThanOrEqual(2, $result['items']->count());
    }
}
