<?php

namespace Tests\Feature\Api\V1\Admin;

use App\Models\Content\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminArticlesTest extends AdminTestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_articles(): void
    {
        $admin = $this->admin();
        Article::create(['title' => 'One', 'slug' => 'one', 'author_id' => $admin->id]);
        Article::create(['title' => 'Two', 'slug' => 'two', 'author_id' => $admin->id]);

        $response = $this->actingAs($admin)->getJson('/api/v1/admin/articles');

        $response->assertOk()->assertJsonStructure(['data']);
    }

    public function test_admin_can_create_article(): void
    {
        $response = $this->actingAs($this->admin())->postJson('/api/v1/admin/articles', [
            'title'   => 'Getting a Visa',
            'content' => 'Long content here.',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'Getting a Visa')
            ->assertJsonPath('data.slug', 'getting-a-visa');
    }

    public function test_store_validates_title(): void
    {
        $response = $this->actingAs($this->admin())->postJson('/api/v1/admin/articles', []);

        $response->assertStatus(422)->assertJsonValidationErrors(['title']);
    }

    public function test_store_generates_unique_slug(): void
    {
        $admin = $this->admin();
        Article::create(['title' => 'Hello', 'slug' => 'hello', 'author_id' => $admin->id]);

        $response = $this->actingAs($admin)->postJson('/api/v1/admin/articles', [
            'title' => 'Hello',
        ]);

        $response->assertStatus(201)->assertJsonPath('data.slug', 'hello-2');
    }

    public function test_admin_can_update_article(): void
    {
        $admin = $this->admin();
        $article = Article::create(['title' => 'Old', 'slug' => 'old', 'author_id' => $admin->id]);

        $response = $this->actingAs($admin)
            ->putJson("/api/v1/admin/articles/{$article->id}", ['title' => 'Renamed']);

        $response->assertOk()->assertJsonPath('data.title', 'Renamed');
    }

    public function test_admin_can_delete_article(): void
    {
        $admin = $this->admin();
        $article = Article::create(['title' => 'Bye', 'slug' => 'bye', 'author_id' => $admin->id]);

        $response = $this->actingAs($admin)
            ->deleteJson("/api/v1/admin/articles/{$article->id}");

        $response->assertOk()->assertJson(['message' => 'Article deleted.']);
    }
}
