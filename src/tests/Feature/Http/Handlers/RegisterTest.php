<?php

namespace Tests\Feature\Http\Handlers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewRegisterForm()
    {
        $response = $this->get(route('register.index'));

        $response->assertSuccessful();
        $response->assertViewIs('register.index');
    }

    public function testUserCannotViewARegistrationFormWhenAuthenticated()
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get(route('register.index'));

        $response->assertRedirect('/');
    }

    public function testUserCanRegister()
    {
        Event::fake();

        $response = $this->post(route('register.user'), [
            'name'                  => 'John Doe',
            'email'                 => 'john@gmail.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $this->assertCount(1, $users = User::all());
        $this->assertAuthenticatedAs($user = $users->first());
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@gmail.com', $user->email);
        $this->assertTrue(Hash::check('password', $user->password));
        Event::assertDispatched(Registered::class, fn($e) => $e->user->id === $user->id);
    }
}