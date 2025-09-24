<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div>
    <form wire:submit="resetPassword" class="register-form">
        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input wire:model="email" id="email" type="email" name="email" required autofocus autocomplete="username" placeholder="ejemplo@correo.com" />
            @error('email') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Nueva contraseña</label>
            <input wire:model="password" id="password" type="password" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres" />
            @error('password') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation">Confirmar contraseña</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repite tu nueva contraseña" />
            @error('password_confirmation') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="submit-btn">
            <i class="fas fa-key"></i>
            Restablecer Contraseña
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
