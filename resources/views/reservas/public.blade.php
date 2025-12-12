@extends('layouts.menu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/estilos-de-reserva.css') }}">
<style>
    .header h1 {
        position: static !important;
        z-index: auto !important;
        font-weight: 900 !important;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5) !important;
    }
    
    .reservations-form {
        margin-top: 20px;
        clear: both;
    }
    
    .form-group label {
        color: #fff !important;
        font-weight: bold;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }
    
    .form-group input,
    .form-group select,
    .form-group textarea {
        background: rgba(255,255,255,0.95) !important;
        border: 2px solid #d4af37 !important;
        color: #333 !important;
    }
    
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        background: rgba(255,255,255,1) !important;
        border-color: #ffd700 !important;
        box-shadow: 0 0 10px rgba(255,215,0,0.5) !important;
        outline: none;
    }
    
    .alert {
        position: relative;
        z-index: 3;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div class="container" style="background: linear-gradient(120deg, #fff 60%, #181828 100%); min-height: 100vh; padding: 20px; position: relative;">
    <div class="header" style="position: relative; z-index: 1; margin-bottom: 40px;">
        <h1 style="font-size: 2.5rem; color: #d4af37; text-align: center; margin-bottom: 10px; font-family: 'Playfair Display', serif; font-weight: 900; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); font-style: normal;"><i class="fas fa-calendar-alt"></i> <b>Hacer Reserva</b></h1>
        <p style="color: #181828; text-align: center; font-size: 1.2rem; margin: 0;">Reserva tu mesa en nuestro restaurante</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: #28a745; color: #fff; padding: 15px; border-radius: 8px; margin: 20px 0;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="background: #dc3545; color: #fff; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="reservations-form" style="background: rgba(128,128,128,0.9); padding: 40px; border-radius: 20px; backdrop-filter: blur(15px); border: 3px solid #d4af37; box-shadow: 0 10px 30px rgba(0,0,0,0.3); position: relative; z-index: 2; max-width: 800px; margin: 0 auto;">
        <form action="{{ route('reservas.publicStore') }}" method="POST">
            @csrf
            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div class="form-group">
                    <label for="nombre" style="color: #ffd700; font-weight: bold; display: block; margin-bottom: 8px;">Nombre Completo *</label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required 
                           style="width: 100%; padding: 12px; border: 2px solid #ffd700; border-radius: 8px; background: rgba(255,255,255,0.9); color: #333;">
                </div>
                <div class="form-group">
                    <label for="email" style="color: #ffd700; font-weight: bold; display: block; margin-bottom: 8px;">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                           style="width: 100%; padding: 12px; border: 2px solid #ffd700; border-radius: 8px; background: rgba(255,255,255,0.9); color: #333;">
                </div>
            </div>
            
            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div class="form-group">
                    <label for="telefono" style="color: #ffd700; font-weight: bold; display: block; margin-bottom: 8px;">Teléfono *</label>
                    <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}" required 
                           style="width: 100%; padding: 12px; border: 2px solid #ffd700; border-radius: 8px; background: rgba(255,255,255,0.9); color: #333;">
                </div>
                <div class="form-group">
                    <label for="fecha" style="color: #ffd700; font-weight: bold; display: block; margin-bottom: 8px;">Fecha *</label>
                    <input type="date" id="fecha" name="fecha" value="{{ old('fecha') }}" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           style="width: 100%; padding: 12px; border: 2px solid #ffd700; border-radius: 8px; background: rgba(255,255,255,0.9); color: #333;">
                </div>
                <div class="form-group">
                    <label for="hora" style="color: #ffd700; font-weight: bold; display: block; margin-bottom: 8px;">Hora *</label>
                    <input type="time" id="hora" name="hora" value="{{ old('hora') }}" required 
                           style="width: 100%; padding: 12px; border: 2px solid #ffd700; border-radius: 8px; background: rgba(255,255,255,0.9); color: #333;">
                </div>
            </div>
            
            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div class="form-group">
                    <label for="personas" style="color: #ffd700; font-weight: bold; display: block; margin-bottom: 8px;">Número de Personas *</label>
                    <select id="personas" name="personas" required 
                            style="width: 100%; padding: 12px; border: 2px solid #ffd700; border-radius: 8px; background: rgba(255,255,255,0.9); color: #333;">
                        <option value="">Seleccionar...</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ old('personas') == $i ? 'selected' : '' }}>{{ $i }} {{ $i == 1 ? 'persona' : 'personas' }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label for="motivo" style="color: #ffd700; font-weight: bold; display: block; margin-bottom: 8px;">Motivo (Opcional)</label>
                    <select id="motivo" name="motivo" 
                            style="width: 100%; padding: 12px; border: 2px solid #ffd700; border-radius: 8px; background: rgba(255,255,255,0.9); color: #333;">
                        <option value="">Seleccionar...</option>
                        <option value="Cumpleaños" {{ old('motivo') == 'Cumpleaños' ? 'selected' : '' }}>Cumpleaños</option>
                        <option value="Aniversario" {{ old('motivo') == 'Aniversario' ? 'selected' : '' }}>Aniversario</option>
                        <option value="Cena de negocios" {{ old('motivo') == 'Cena de negocios' ? 'selected' : '' }}>Cena de negocios</option>
                        <option value="Otro" {{ old('motivo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group" style="margin-bottom: 30px;">
                <label for="nota" style="color: #ffd700; font-weight: bold; display: block; margin-bottom: 8px;">Notas Adicionales (Opcional)</label>
                <textarea id="nota" name="nota" rows="4" placeholder="Alergias, preferencias especiales, etc."
                          style="width: 100%; padding: 12px; border: 2px solid #ffd700; border-radius: 8px; background: rgba(255,255,255,0.9); color: #333; resize: vertical;">{{ old('nota') }}</textarea>
            </div>
            
            <div class="form-actions" style="text-align: center;">
                <button type="submit" 
                        style="background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%); color: #000; padding: 15px 40px; border: none; border-radius: 25px; font-size: 18px; font-weight: 900; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(255,215,0,0.3);">
                    <i class="fas fa-calendar-check"></i> <strong>Confirmar Reserva</strong>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection