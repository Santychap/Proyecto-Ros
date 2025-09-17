<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response
            ->assertOk()
            ->assertSeeVolt('pages.auth.register');
    }

    public function test_new_cliente_can_register(): void
    {
        $component = Volt::test('pages.auth.register')
            ->set('name', 'Cliente User')
            ->set('email', 'cliente@example.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->set('rol', 'cliente');

        $component->call('register');

        $component->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'cliente@example.com',
            'rol' => 'cliente',
        ]);
    }

    public function test_new_empleado_can_register(): void
    {
        $component = Volt::test('pages.auth.register')
            ->set('name', 'Empleado User')
            ->set('email', 'empleado@example.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->set('rol', 'empleado');

        $component->call('register');

        $component->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'empleado@example.com',
            'rol' => 'empleado',
        ]);
    }
}
