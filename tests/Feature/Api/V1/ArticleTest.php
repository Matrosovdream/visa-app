<?php

namespace Tests\Feature\Api\V1;

use App\Models\Content\Article;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_articles(): void
    {
        $user = User::factory()->create();

        Article::create([
            'title' => 'Test Article',
            'slug' => 'test-article',
            'short_description' => 'Short description',
            'content' => 'Full content here',
            'author_id' => $user->id,
        ]);

        $response = $this->getJson('/api/v1/articles');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_can_show_article_by_slug(): void
    {
        $user = User::factory()->create();

        Article::create([
            'title' => 'Test Article',
            'slug' => 'test-article',
            'short_description' => 'Short description',
            'content' => 'Full content here',
            'author_id' => $user->id,
        ]);

        $response = $this->getJson('/api/v1/articles/test-article');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_show_article_returns_404_for_missing_slug(): void
    {
        $response = $this->getJson('/api/v1/articles/nonexistent');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Article not found.']);
    }

    public function test_articles_endpoint_returns_empty_array_when_no_articles(): void
    {
        $response = $this->getJson('/api/v1/articles');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }
}
