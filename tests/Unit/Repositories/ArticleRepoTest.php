<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Content\ArticleRepo;
use App\Models\Content\Article;
use App\Models\User\User;

class ArticleRepoTest extends TestCase
{
    use RefreshDatabase;

    private ArticleRepo $repo;
    private User $author;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = new ArticleRepo();
        $this->author = User::create([
            'name' => 'Author',
            'email' => 'author@test.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_create_article(): void
    {
        $result = $this->repo->create([
            'title' => 'Test Article',
            'slug' => 'test-article',
            'content' => 'Test content here',
            'author_id' => $this->author->id,
        ]);

        $this->assertNotNull($result);
        $this->assertEquals('Test Article', $result['title']);
        $this->assertArrayHasKey('Model', $result);
    }

    public function test_get_by_slug(): void
    {
        Article::create([
            'title' => 'Slug Article',
            'slug' => 'slug-article',
            'content' => 'Content',
            'author_id' => $this->author->id,
        ]);

        $result = $this->repo->getBySlug('slug-article');

        $this->assertNotNull($result);
        $this->assertEquals('Slug Article', $result['title']);
    }

    public function test_update_article(): void
    {
        $article = Article::create([
            'title' => 'Original',
            'slug' => 'original',
            'content' => 'Original content',
            'author_id' => $this->author->id,
        ]);

        $result = $this->repo->update($article->id, ['title' => 'Updated']);

        $this->assertNotNull($result);
        $this->assertEquals('Updated', $result['title']);
    }

    public function test_delete_article(): void
    {
        $article = Article::create([
            'title' => 'Delete Me',
            'slug' => 'delete-me',
            'content' => 'Will be deleted',
            'author_id' => $this->author->id,
        ]);

        $deleted = $this->repo->delete($article->id);
        $this->assertTrue($deleted);
    }

    public function test_mapitem_returns_correct_keys(): void
    {
        $article = Article::create([
            'title' => 'Keys Test',
            'slug' => 'keys-test',
            'content' => 'Testing keys',
            'author_id' => $this->author->id,
        ]);

        $result = $this->repo->getByID($article->id);

        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('title', $result);
        $this->assertArrayHasKey('slug', $result);
        $this->assertArrayHasKey('content', $result);
        $this->assertArrayHasKey('Model', $result);
    }
}
