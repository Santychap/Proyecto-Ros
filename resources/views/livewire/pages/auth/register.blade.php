<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $rol = ''; // Cambiado a 'rol'

    public function register(): void
{
    $validated = $this->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        'rol' => ['required', 'in:cliente,empleado'],
    ]);

    $validated['password'] = Hash::make($validated['password']);

    $user = User::create($validated);

    // Ya no se necesita assignRole()

    event(new Registered($user));

    Auth::login($user);

    $this->redirect(route('dashboard', absolute: false), navigate: true);
}

    public function render(): mixed
    {
        return <<<'blade'
<div>
    <form wire:submit.prevent="register" class="register-form">
        <div class="form-group">
            <label for="name">Nombre completo</label>
            <input type="text" wire:model="name" id="name" placeholder="Ingresa tu nombre completo" required />
            @error('name') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>
        
        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" wire:model="email" id="email" placeholder="ejemplo@correo.com" required />
            @error('email') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>
        
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" wire:model="password" id="password" placeholder="Mínimo 8 caracteres" required />
            @error('password') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>
        
        <div class="form-group">
            <label for="password_confirmation">Confirmar contraseña</label>
            <input type="password" wire:model="password_confirmation" id="password_confirmation" placeholder="Repite tu contraseña" required />
        </div>
        
        <div class="form-group">
            <label for="rol">Tipo de cuenta</label>
            <select wire:model="rol" id="rol" required style="width: 100%; padding: 14px 16px; border: 2px solid #e1e8ed; border-radius: 8px; font-size: 1rem; background: rgba(255, 255, 255, 0.9);">
                <option value="">Selecciona un tipo de cuenta</option>
                <option value="cliente">Cliente</option>
                <option value="empleado">Empleado</option>
            </select>
            @error('rol') <span style="color: #dc3545; font-size: 0.8rem;">{{ $message }}</span> @enderror
        </div>
        
        <button type="submit" class="submit-btn">
            <i class="fas fa-user-plus"></i>
            Crear cuenta
        </button>
    </form>
    
    <div class="terms">
        <p>
            ¿Ya tienes cuenta? 
            <a href="/login" wire:navigate>
                Inicia sesión aquí
            </a>
        </p>
    </div>
</div>
blade;
    }
};
?>
