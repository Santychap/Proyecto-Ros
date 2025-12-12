<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <div style="color: #9ca3af; font-size: 0.9rem; margin-bottom: 25px; text-align: center; line-height: 1.5;">
        ¿Olvidaste tu contraseña? No hay problema. Solo proporciona tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="success-message">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="sendPasswordResetLink" class="register-form">
        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input wire:model="email" id="email" type="email" name="email" required autofocus placeholder="ejemplo@correo.com" />
            @error('email') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="submit-btn">
            <i class="fas fa-paper-plane"></i>
            Enviar Enlace de Recuperación
        </button>
    </form>
    
    <div class="terms">
        <p>
            ¿Recordaste tu contraseña? 
            <a href="/login" wire:navigate>
                Inicia sesión aquí
            </a>
        </p>
    </div>
</div>
