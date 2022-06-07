<?php

namespace Tests\Feature\Http\Handlers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewLoginForm()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('login.index');
    }

    public function testUserCannotViewLoginFormWhenAuthenticated()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/');
    }

    public function testUserCanLoginWithCorrectCredentials()
    {
        $password = 'password';

        $user = User::factory()->create([
            'password' => $password,
        ]);

        $response = $this->post(route('login.auth'), [
            'email'    => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function testUserCannotLoginWithIncorrectPassword()
    {
        $user = User::factory()->create([
            'password' => bcrypt('passwd'),
        ]);
        
        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('login.index'));
        $response->assertSessionHasErrors('password');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testRememberMeFunctionality()
    {
        $password = 'password';

        $user = User::factory()->create([
            'id'       => random_int(1, 100),
            'password' => $password,
        ]);
        
        $response = $this->post(route('login.auth'), [
            'email'    => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);
        
        $response->assertRedirect('/');
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $user->id,
            $user->getRememberToken(),
            $user->password,
        ]));
        $this->assertAuthenticatedAs($user);
    }

    public function testUserCannotLogoutWhenNotAuthenticated()
    {
        $this->assertGuest();
        $response = $this->get(route('logout'));

        $response->assertRedirect(route('login.index'));
        $this->assertGuest();
    }

    public function testUserCanLogout()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('logout'));

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}