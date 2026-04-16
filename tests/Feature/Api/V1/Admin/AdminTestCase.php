<?php

namespace Tests\Feature\Api\V1\Admin;

use App\Models\User\Role;
use App\Models\User\User;
use Tests\TestCase;

abstract class AdminTestCase extends TestCase
{
    protected Role $adminRole;
    protected Role $managerRole;
    protected Role $userRole;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRole    = Role::create(['title' => 'User', 'slug' => 'user', 'is_default' => true]);
        $this->managerRole = Role::create(['title' => 'Manager', 'slug' => 'manager']);
        $this->adminRole   = Role::create(['title' => 'Admin', 'slug' => 'admin']);
    }

    protected function admin(): User
    {
        $user = User::factory()->create();
        $user->roles()->attach($this->adminRole->id);
        return $user;
    }

    protected function manager(): User
    {
        $user = User::factory()->create();
        $user->roles()->attach($this->managerRole->id);
        return $user;
    }

    protected function regularUser(): User
    {
        $user = User::factory()->create();
        $user->roles()->attach($this->userRole->id);
        return $user;
    }
}
