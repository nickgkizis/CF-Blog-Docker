<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Start the session so that CSRF tokens are persisted.
        $this->startSession();
    }

    /**
     * Test that the index page shows paginated articles.
     */
    public function testIndexDisplaysArticles()
    {
        Article::factory()->count(10)->create();

        $response = $this->get(route('articles.index'));

        $response->assertStatus(200);
        $response->assertViewHas('articles');
        // Ensure pagination is working (default page size is 5)
        $this->assertCount(5, $response->viewData('articles'));
    }

    /**
     * Test the show method displays the article and its user.
     */
    public function testShowDisplaysArticleAndUser()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('articles.show', $article->id));

        $response->assertStatus(200);
        $response->assertViewHas('article', $article);
        $response->assertViewHas('user', $user);
    }

    /**
     * Test that authenticated users can view the create form.
     */
    public function testCreateShowsFormForAuthenticatedUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('articles.create'));
        $response->assertStatus(200);
        $response->assertViewIs('articles.create');
    }

    /**
     * Test storing a new article.
     */
    public function testStoreCreatesArticleForAuthenticatedUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'title'   => 'Test Article',
            'content' => 'This is a test article content.',
        ];

        // Capture the token once after starting the session.
        $token = csrf_token();

        $response = $this->withSession(['_token' => $token])
                         ->post(
                             route('articles.store'),
                             array_merge($data, ['_token' => $token])
                         );

        $response->assertRedirect(route('articles.index'));
        $this->assertDatabaseHas('articles', [
            'title'   => $data['title'],
            'content' => $data['content'],
            'user_id' => $user->id,
        ]);
    }

    /**
     * Test that editing an article only works for the owner.
     */
    public function testEditOnlyAccessibleByOwner()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);

        // Owner can access edit.
        $this->actingAs($user);
        $response = $this->get(route('articles.edit', $article->id));
        $response->assertStatus(200);
        $response->assertViewHas('article', $article);

        // Another user should be redirected with an error message.
        $anotherUser = User::factory()->create();
        $this->actingAs($anotherUser);
        $response = $this->get(route('articles.edit', $article->id));
        $response->assertRedirect(route('articles.index'));
        $response->assertSessionHas('error', 'You are not authorized to edit this article.');
    }

    /**
     * Test updating an article.
     */
    public function testUpdateArticle()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id,
            'title'   => 'Old Title',
            'content' => 'Old content.',
        ]);

        $updateData = [
            'title'   => 'New Title',
            'content' => 'New updated content.',
        ];

        $token = csrf_token();

        $response = $this->withSession(['_token' => $token])
                         ->put(
                             route('articles.update', $article->id),
                             array_merge($updateData, ['_token' => $token])
                         );

        $response->assertRedirect(route('articles.show', $article->id));
        $response->assertSessionHas('success', 'Article updated successfully!');
        $this->assertDatabaseHas('articles', [
            'id'      => $article->id,
            'title'   => $updateData['title'],
            'content' => $updateData['content'],
        ]);
    }

    /**
     * Test deleting an article.
     */
    public function testDestroyArticle()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $article = Article::factory()->create(['user_id' => $user->id]);

        $token = csrf_token();

        $response = $this->withSession(['_token' => $token])
                         ->delete(
                             route('articles.destroy', $article->id),
                             ['_token' => $token]
                         );

        $response->assertRedirect(route('articles.index'));
        $response->assertSessionHas('success', 'Article deleted successfully!');
        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    /**
     * Test search by user.
     */
    public function testSearchByUser()
    {
        $user = User::factory()->create(['name' => 'John Doe']);
        Article::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('articles.searchByUser', ['search' => 'John']));
        $response->assertStatus(200);
        $response->assertViewHas('articles');
        $response->assertSee('John Doe');
    }

    /**
     * Test search by article title or content.
     */
    public function testSearchByArticle()
    {
        $article = Article::factory()->create([
            'title'   => 'Unique Title',
            'content' => 'Some unique content',
        ]);

        $response = $this->get(route('articles.searchByArticle', ['search' => 'Unique']));
        $response->assertStatus(200);
        $response->assertViewHas('articles');
        $response->assertSee('Unique Title');
    }

    /**
     * Test sorting articles by date.
     */
    public function testSortByDate()
    {
        Article::factory()->create(['created_at' => now()->subDay()]);
        Article::factory()->create(['created_at' => now()]);

        // Test ascending order.
        $response = $this->get(route('articles.sort', ['order' => 'asc']));
        $response->assertStatus(200);
        $response->assertViewHas('articles');

        // Test descending order.
        $response = $this->get(route('articles.sort', ['order' => 'desc']));
        $response->assertStatus(200);
        $response->assertViewHas('articles');

        // Test invalid order: assert a 404 response.
        $this->get(route('articles.sort', ['order' => 'invalid']))->assertStatus(404);
    }
}
