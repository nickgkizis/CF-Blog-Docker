<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the index method (get all articles).
     *
     * @return void
     */
    public function test_index()
    {
        $user = User::factory()->create(); // Create a user
        Article::factory(3)->create(['user_id' => $user->id]); // Create 3 articles for that user

        $response = $this->get(route('articles.index'));

        $response->assertStatus(200);
        $response->assertViewHas('articles');
    }

    /**
     * Test the show method (view a specific article).
     *
     * @return void
     */
    public function test_show()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('articles.show', $article->id));

        $response->assertStatus(200);
        $response->assertViewHas('article', $article);
        $response->assertViewHas('user', $user);
    }

    /**
     * Test the create method (show article creation form).
     *
     * @return void
     */
    public function test_create()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('articles.create'));

        $response->assertStatus(200);
        $response->assertViewIs('articles.create');
    }

    /**
     * Test the store method (store a new article).
     *
     * @return void
     */
    public function test_store()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('articles.store'), [
            'title' => 'Test Article',
            'content' => 'This is a test article.',
        ]);

        $response->assertRedirect(route('articles.index'));
        $response->assertSessionHas('success', 'Article created successfully!');
        $this->assertDatabaseHas('articles', [
            'title' => 'Test Article',
            'content' => 'This is a test article.',
            'user_id' => $user->id,
        ]);
    }

    /**
     * Test the edit method (show article edit form).
     *
     * @return void
     */
    public function test_edit()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->get(route('articles.edit', $article->id));

        $response->assertStatus(200);
        $response->assertViewHas('article', $article);
    }

    /**
     * Test unauthorized user trying to edit another user's article.
     *
     * @return void
     */
    public function test_edit_unauthorized()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $anotherUser->id]);
        $this->actingAs($user);

        $response = $this->get(route('articles.edit', $article->id));

        $response->assertRedirect(route('articles.index'));
        $response->assertSessionHas('error', 'You are not authorized to edit this article.');
    }

    /**
     * Test the update method (update an article).
     *
     * @return void
     */
    public function test_update()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->put(route('articles.update', $article->id), [
            'title' => 'Updated Title',
            'content' => 'Updated content for the article.',
        ]);

        $response->assertRedirect(route('articles.show', $article->id));
        $response->assertSessionHas('success', 'Article updated successfully!');
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Updated Title',
            'content' => 'Updated content for the article.',
        ]);
    }

    /**
     * Test the destroy method (delete an article).
     *
     * @return void
     */
    public function test_destroy()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->delete(route('articles.destroy', $article->id));

        $response->assertRedirect(route('articles.index'));
        $response->assertSessionHas('success', 'Article deleted successfully!');
        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }
}