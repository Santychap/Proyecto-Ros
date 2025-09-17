<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    public function render(): string
    {
        return <<<'HTML'
<div class="min-h-screen flex items-center justify-center bg-black">
    <div class="bg-gray-800 border-2 border-yellow-400 rounded-lg p-8 w-full max-w-sm text-white shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Iniciar Sesión</h2>

        <form :submit="login" class="space-y-4">
            <!-- Email -->
            <div>
                <label for="email" class="block mb-1 font-semibold">Email</label>
                <input :model="form.email" id="email" type="email" name="email" required autofocus
                    class="w-full px-3 py-2 rounded border border-yellow-400 bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block mb-1 font-semibold">Password</label>
                <input :model="form.password" id="password" type="password" name="password" required
                    class="w-full px-3 py-2 rounded border border-yellow-400 bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400" />
            </div>

            <!-- Remember me -->
            <div class="flex items-center">
                <input :model="form.remember" id="remember" type="checkbox" class="mr-2">
                <label for="remember" class="text-white">Remember me</label>
            </div>

            <button type="submit"
                class="w-full bg-yellow-400 text-black font-bold py-2 px-4 rounded hover:bg-yellow-500 transition-colors">Log In</button>
        </form>

        <div class="mt-4 text-center text-sm">
            <a href="{{ route('register') }}" class="underline hover:text-yellow-400">¿No tienes cuenta? Regístrate</a><br>
            <a href="{{ route('password.request') }}" class="underline hover:text-yellow-400">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</div>
HTML;
    }
};
