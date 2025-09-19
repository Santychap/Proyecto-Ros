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
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="login-options">
        <form wire:submit="login" class="register-form">
            <!-- Email Address -->
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username" placeholder="Ingresa tu email" />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password" placeholder="Ingresa tu contraseña" />
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="form-group">
                <label for="remember" style="display: flex; align-items: center; gap: 8px;">
                    <input wire:model="form.remember" id="remember" type="checkbox" name="remember">
                    <span>{{ __('Remember me') }}</span>
                </label>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-sign-in-alt"></i>
                {{ __('Log in') }}
            </button>

            <div style="text-align: center; margin-top: 15px;">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" wire:navigate style="color: #666; text-decoration: none; font-size: 0.9rem;">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
    
    <div class="terms">
        <p>
            ¿No tienes cuenta? 
            <a href="/register" wire:navigate>
                Regístrate aquí
            </a>
        </p>
    </div>
</div>