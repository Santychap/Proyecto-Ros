@php
    $user = auth()->user();
    $layout = match($user->rol) {
        'admin' => 'layouts.admin',
        'empleado' => 'layouts.empleado', 
        default => 'layouts.cliente'
    };
@endphp

@extends($layout)

@section('title', 'Mi Perfil')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1 class="profile-title">
            <i class="fas fa-user-circle"></i>
            Mi Perfil
        </h1>
        <p class="profile-subtitle">
            Actualiza tu información personal y configuración de cuenta
        </p>
    </div>

    <div class="profile-sections">
        <div class="profile-card">
            <div class="card-header">
                <h2><i class="fas fa-user"></i> Información Personal</h2>
            </div>
            <div class="card-content">
                <livewire:profile.update-profile-information-form />
            </div>
        </div>

        <div class="profile-card">
            <div class="card-header">
                <h2><i class="fas fa-lock"></i> Cambiar Contraseña</h2>
            </div>
            <div class="card-content">
                <livewire:profile.update-password-form />
            </div>
        </div>

        <div class="profile-card">
            <div class="card-header">
                <h2><i class="fas fa-trash-alt"></i> Eliminar Cuenta</h2>
            </div>
            <div class="card-content">
                <livewire:profile.delete-user-form />
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.profile-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 2rem;
}

.profile-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    border-radius: 20px;
    border: 2px solid var(--color-primary);
}

.profile-title {
    font-size: 2.5rem;
    color: #000000 !important;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.profile-subtitle {
    font-size: 1.1rem;
    color: #000000 !important;
}

.profile-sections {
    display: flex;
    flex-direction: column;
    gap: 2.5rem;
}

.profile-card {
    background: #000000 !important;
    border: 2px solid var(--color-primary);
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.profile-card:hover {
    border-color: var(--color-primary-light);
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.3);
}

.card-header {
    background: rgba(255, 215, 0, 0.1);
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 215, 0, 0.3);
}

.card-header h2 {
    color: var(--color-primary) !important;
    font-size: 1.3rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-content {
    padding: 2.5rem;
    color: #ffffff !important;
    line-height: 1.7 !important;
}

/* Estilos para los formularios de Livewire */
.card-content form {
    max-width: none;
}

.card-content label {
    color: var(--color-primary) !important;
    font-weight: 600;
    margin-bottom: 0.75rem !important;
    display: block !important;
}

.card-content p {
    color: #ffffff !important;
    margin-bottom: 1rem !important;
    line-height: 1.6 !important;
}

.card-content div {
    color: #ffffff !important;
    margin-bottom: 1rem !important;
}

.card-content input[type="text"],
.card-content input[type="email"],
.card-content input[type="password"] {
    background: rgba(255, 255, 255, 0.1) !important;
    border: 2px solid var(--color-primary) !important;
    border-radius: 8px !important;
    color: #ffffff !important;
    padding: 0.75rem !important;
    margin-bottom: 1.5rem !important;
    width: 100% !important;
    box-sizing: border-box !important;
}

.card-content input:focus {
    outline: none !important;
    border-color: var(--color-primary-light) !important;
    box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.3) !important;
}

.card-content button {
    background: var(--color-primary) !important;
    color: #000 !important;
    border: none !important;
    padding: 0.75rem 1.5rem !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
    margin-top: 1rem !important;
    margin-bottom: 1rem !important;
}

.card-content button:hover {
    background: var(--color-primary-light) !important;
    transform: translateY(-2px) !important;
}

.card-content .text-red-600 {
    color: #ff4757 !important;
}

.card-content .text-green-600 {
    color: #51cf66 !important;
}

.card-content .text-gray-600 {
    color: #cccccc !important;
}

.card-content .text-gray-900 {
    color: #ffffff !important;
}

/* Forzar colores en todos los elementos de Livewire */
.card-content * {
    color: #ffffff !important;
}

.card-content label {
    color: var(--color-primary) !important;
}

.card-content .text-red-600,
.card-content .text-red-500 {
    color: #ff4757 !important;
}

.card-content .text-green-600,
.card-content .text-green-500 {
    color: #51cf66 !important;
}

/* Espaciado adicional para formularios */
.card-content .mt-4 {
    margin-top: 1.5rem !important;
}

.card-content .mb-4 {
    margin-bottom: 1.5rem !important;
}

.card-content .space-y-6 > * + * {
    margin-top: 1.5rem !important;
}

.card-content .grid {
    gap: 1.5rem !important;
}

@media (max-width: 768px) {
    .profile-container {
        padding: 1rem;
    }
    
    .profile-title {
        font-size: 2rem;
    }
    
    .card-content {
        padding: 1.5rem;
    }
}
</style>
@endpush
@endsection
