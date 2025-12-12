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
    @if (session('status'))
        <div class="success-message">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="login" class="register-form">
        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username" placeholder="ejemplo@correo.com" />
            @error('form.email') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password" placeholder="Ingresa tu contraseña" />
            @error('form.password') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-group">
            <label for="remember" style="display: flex; align-items: center; gap: 8px; color: #9ca3af;">
                <input wire:model="form.remember" id="remember" type="checkbox" name="remember">
                <span>Recordarme</span>
            </label>
        </div>

        <button type="submit" class="submit-btn">
            <i class="fas fa-sign-in-alt"></i>
            Iniciar Sesión
        </button>

        @if (Route::has('password.request'))
            <div class="forgot-password-link">
                <a href="{{ route('password.request') }}" wire:navigate>
                    ¿Olvidaste tu contraseña?
                </a>
            </div>
        @endif
    </form>
    
    <div class="terms">
        <p>
            ¿No tienes cuenta? 
            <a href="/register" wire:navigate>
                Regístrate aquí
            </a>
        </p>
    </div>
</div>