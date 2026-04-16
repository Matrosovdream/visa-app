<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\hasRole;
use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class HasRoleTest extends TestCase
{
    use RefreshDatabase;

    private hasRole $middleware;

    protected function setUp(): void
    {
        parent::setUp();

        $this->middleware = new hasRole();

        Role::create(['title' => 'User', 'slug' => 'user', 'is_default' => true]);
        Role::create(['title' => 'Admin', 'slug' => 'admin']);
        Role::create(['title' => 'Manager', 'slug' => 'manager']);
    }

    private function userWithRole(string $slug): User
    {
        $user = User::factory()->create();
        $user->setRole($slug);
        return $user;
    }

    public function test_admin_passes_admin_gate(): void
    {
        $this->actingAs($this->userWithRole('admin'));

        $response = $this->middleware->handle(Request::create('/admin'), fn () => new Response('ok'), 'admin');

        $this->assertSame('ok', $response->getContent());
    }

    public function test_user_is_redirected_from_admin_gate(): void
    {
        $this->actingAs($this->userWithRole('user'));

        $response = $this->middleware->handle(Request::create('/admin'), fn () => new Response('ok'), 'admin');

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_manager_passes_admin_or_manager_gate(): void
    {
        $this->actingAs($this->userWithRole('manager'));

        $response = $this->middleware->handle(
            Request::create('/x'),
            fn () => new Response('ok'),
            'admin',
            'manager',
        );

        $this->assertSame('ok', $response->getContent());
    }

    public function test_user_is_blocked_by_admin_or_manager_gate(): void
    {
        $this->actingAs($this->userWithRole('user'));

        $response = $this->middleware->handle(
            Request::create('/x'),
            fn () => new Response('ok'),
            'admin',
            'manager',
        );

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}
