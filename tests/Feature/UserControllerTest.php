<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Start the session so that CSRF tokens are persisted.
        $this->startSession();
    }

    /**
     * Test registration form display.
     */
    public function testShowRegistrationForm()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    /**
     * Test user registration.
     */
    public function testRegisterNewUser()
    {
        $data = [
            'name'                  => 'Test User',
            'email'                 => 'testuser@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ];

        $token = csrf_token();

        $response = $this->withSession(['_token' => $token])
                         ->post(
                             route('register'),
                             array_merge($data, ['_token' => $token])
                         );

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
            'name'  => 'Test User',
        ]);
    }

    /**
     * Test login form display.
     */
    public function testShowLoginForm()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /**
     * Test login functionality with valid credentials.
     */
    public function testLoginWithValidCredentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $credentials = [
            'email'    => $user->email,
            'password' => 'password123',
        ];

        $token = csrf_token();

        $response = $this->withSession(['_token' => $token])
                         ->post(
                             route('login'),
                             array_merge($credentials, ['_token' => $token])
                         );

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
        $this->assertTrue(session()->has('login_success'));
    }

    /**
     * Test login functionality with invalid credentials.
     */
    public function testLoginWithInvalidCredentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $credentials = [
            'email'    => $user->email,
            'password' => 'wrongpassword',
        ];

        $token = csrf_token();

        $response = $this->from(route('login'))
                         ->withSession(['_token' => $token])
                         ->post(
                             route('login'),
                             array_merge($credentials, ['_token' => $token])
                         );

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test logout functionality.
     */
    public function testLogout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $token = csrf_token();

        $response = $this->withSession(['_token' => $token])
                         ->post(route('logout'), ['_token' => $token]);

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /**
     * Test listing users.
     */
    public function testIndexDisplaysUsers()
    {
        User::factory()->count(10)->create();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('users.index'));
        $response->assertStatus(200);
        $response->assertViewHas('users');
    }

    /**
     * Test showing a specific user.
     */
    public function testShowDisplaysUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('users.show', $user->id));
        $response->assertStatus(200);
        $response->assertViewHas('user', $user);
    }

    /**
     * Test user deletion.
     */
    public function testDestroyUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $userToDelete = User::factory()->create();

        $token = csrf_token();

        $response = $this->withSession(['_token' => $token])
                         ->delete(
                             route('users.destroy', $userToDelete->id),
                             ['_token' => $token]
                         );

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'User deleted successfully!');
        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }
}
