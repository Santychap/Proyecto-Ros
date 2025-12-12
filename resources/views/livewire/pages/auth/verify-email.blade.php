<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <div style="color: #9ca3af; font-size: 0.9rem; margin-bottom: 25px; text-align: center; line-height: 1.5;">
        ¡Gracias por registrarte! Antes de comenzar, verifica tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar. Si no recibiste el correo, con gusto te enviaremos otro.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="success-message">
            Se ha enviado un nuevo enlace de verificación a la dirección de correo que proporcionaste durante el registro.
        </div>
    @endif

    <div class="register-form">
        <button wire:click="sendVerification" class="submit-btn">
            <i class="fas fa-paper-plane"></i>
            Reenviar Correo de Verificación
        </button>
        
        <div style="text-align: center; margin-top: 20px;">
            <button wire:click="logout" style="background: none; border: none; color: #9ca3af; text-decoration: underline; cursor: pointer; font-size: 0.9rem;">
                Cerrar Sesión
            </button>
        </div>
    </div>
</div>
