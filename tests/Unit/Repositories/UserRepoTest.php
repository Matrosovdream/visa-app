<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\User\UserRepo;
use App\Models\User\User;

class UserRepoTest extends TestCase
{
    use RefreshDatabase;

    private UserRepo $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = new UserRepo();
    }

    public function test_create_user(): void
    {
        $result = $this->repo->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->assertNotNull($result);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('Model', $result);
        $this->assertEquals('Test User', $result['name']);
        $this->assertEquals('test@example.com', $result['email']);
    }

    public function test_get_user_by_id(): void
    {
        $user = User::create([
            'name' => 'Find Me',
            'email' => 'findme@example.com',
            'password' => bcrypt('password'),
        ]);

        $result = $this->repo->getByID($user->id);

        $this->assertNotNull($result);
        $this->assertEquals($user->id, $result['id']);
        $this->assertEquals('Find Me', $result['name']);
    }

    public function test_get_user_by_email(): void
    {
        User::create([
            'name' => 'Email User',
            'email' => 'emailuser@example.com',
            'password' => bcrypt('password'),
        ]);

        $result = $this->repo->getByEmail('emailuser@example.com');

        $this->assertNotNull($result);
        $this->assertEquals('Email User', $result['name']);
    }

    public function test_update_user(): void
    {
        $user = User::create([
            'name' => 'Original Name',
            'email' => 'update@example.com',
            'password' => bcrypt('password'),
        ]);

        $result = $this->repo->update($user->id, ['name' => 'Updated Name']);

        $this->assertNotNull($result);
        $this->assertEquals('Updated Name', $result['name']);
    }

    public function test_delete_user(): void
    {
        $user = User::create([
            'name' => 'Delete Me',
            'email' => 'delete@example.com',
            'password' => bcrypt('password'),
        ]);

        $deleted = $this->repo->delete($user->id);

        $this->assertTrue($deleted);
        $this->assertNull($this->repo->getByID($user->id));
    }

    public function test_get_all_users_paginated(): void
    {
        User::create(['name' => 'User 1', 'email' => 'u1@test.com', 'password' => bcrypt('p')]);
        User::create(['name' => 'User 2', 'email' => 'u2@test.com', 'password' => bcrypt('p')]);

        $result = $this->repo->getAll([], 10);

        $this->assertArrayHasKey('items', $result);
        $this->assertArrayHasKey('Model', $result);
        $this->assertGreaterThanOrEqual(2, $result['items']->count());
    }

    public function test_mapitem_returns_correct_keys(): void
    {
        $user = User::create([
            'name' => 'Map Test',
            'email' => 'map@test.com',
            'password' => bcrypt('p'),
        ]);

        $result = $this->repo->getByID($user->id);

        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('email', $result);
        $this->assertArrayHasKey('roles', $result);
        $this->assertArrayHasKey('Model', $result);
        $this->assertInstanceOf(User::class, $result['Model']);
    }
}
