<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Geo\CountryRepo;
use App\Models\Geo\Country;

class CountryRepoTest extends TestCase
{
    use RefreshDatabase;

    private CountryRepo $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = new CountryRepo();
    }

    public function test_create_country(): void
    {
        $result = $this->repo->create([
            'name' => 'Test Country',
            'code' => 'TC',
            'slug' => 'test-country',
        ]);

        $this->assertNotNull($result);
        $this->assertEquals('Test Country', $result['name']);
        $this->assertEquals('TC', $result['code']);
        $this->assertArrayHasKey('Model', $result);
    }

    public function test_get_by_id(): void
    {
        $country = Country::create(['name' => 'France', 'code' => 'FR', 'slug' => 'france']);
        $result = $this->repo->getByID($country->id);

        $this->assertNotNull($result);
        $this->assertEquals('France', $result['name']);
    }

    public function test_find_by_slug(): void
    {
        Country::create(['name' => 'Germany', 'code' => 'DE', 'slug' => 'germany']);
        $result = $this->repo->findBySlug('germany');

        $this->assertNotNull($result);
        $this->assertEquals('Germany', $result['name']);
    }

    public function test_delete_country(): void
    {
        $country = Country::create(['name' => 'Delete Me', 'code' => 'DM', 'slug' => 'delete-me']);
        $deleted = $this->repo->delete($country->id);

        $this->assertTrue($deleted);
        $this->assertNull($this->repo->getByID($country->id));
    }

    public function test_filter_with_operator(): void
    {
        Country::create(['name' => 'Alpha', 'code' => 'AL', 'slug' => 'alpha']);
        Country::create(['name' => 'Beta', 'code' => 'BE', 'slug' => 'beta']);

        $result = $this->repo->getAll(['name' => ['operator' => 'LIKE', 'value' => '%Alpha%']], 10);

        $this->assertGreaterThanOrEqual(1, $result['items']->count());
    }

    public function test_count(): void
    {
        Country::create(['name' => 'One', 'code' => 'O1', 'slug' => 'one']);
        Country::create(['name' => 'Two', 'code' => 'O2', 'slug' => 'two']);

        $count = $this->repo->count();
        $this->assertGreaterThanOrEqual(2, $count);
    }

    public function test_exists(): void
    {
        $country = Country::create(['name' => 'Exists', 'code' => 'EX', 'slug' => 'exists']);

        $this->assertTrue($this->repo->exists(['id' => $country->id]));
        $this->assertFalse($this->repo->exists(['id' => 99999]));
    }

    public function test_get_first(): void
    {
        Country::create(['name' => 'First', 'code' => 'F1', 'slug' => 'first']);

        $result = $this->repo->getFirst(['code' => 'F1']);

        $this->assertNotNull($result);
        $this->assertEquals('First', $result['name']);
    }
}
