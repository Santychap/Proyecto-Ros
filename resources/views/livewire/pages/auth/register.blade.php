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
    <form wire:submit.prevent="register">
        <input type="text" wire:model="name" placeholder="Nombre" required />
        <input type="email" wire:model="email" placeholder="Correo electrónico" required />
        <input type="password" wire:model="password" placeholder="Contraseña" required />
        <input type="password" wire:model="password_confirmation" placeholder="Confirmar contraseña" required />
        <select wire:model="rol" required>
            <option value="">Selecciona un rol</option>
            <option value="cliente">Cliente</option>
            <option value="empleado">Empleado</option>
        </select>
        <button type="submit">Registrar</button>
    </form>
</div>
blade;
    }
};
?>
