@extends('layouts.menu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/estilos-de-reserva.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="header">
        <h1><i class="fas fa-calendar-alt"></i> Hacer Reserva</h1>
        <p>Reserva tu mesa en nuestro restaurante</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: #51cf66; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="background: #ff6b6b; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="reservations-table">
        <div class="table-header">
            <h3>Formulario de Reserva</h3>
            <p>Completa los datos para reservar tu mesa</p>
        </div>
        
        <div style="padding: 30px;">
            <form action="{{ route('reservas.publicStore') }}" method="POST">
                @csrf
                
                <div class="filter-row" style="margin-bottom: 20px;">
                    <div class="filter-group">
                        <label for="nombre">Nombre completo *</label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    </div>
                    
                    <div class="filter-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="filter-row" style="margin-bottom: 20px;">
                    <div class="filter-group">
                        <label for="telefono">Teléfono *</label>
                        <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}" required>
                    </div>
                    
                    <div class="filter-group">
                        <label for="personas">Número de personas *</label>
                        <select id="personas" name="personas" required>
                            <option value="">Selecciona...</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ old('personas') == $i ? 'selected' : '' }}>{{ $i }} {{ $i == 1 ? 'persona' : 'personas' }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="filter-row" style="margin-bottom: 20px;">
                    <div class="filter-group">
                        <label for="fecha">Fecha de reserva *</label>
                        <input type="date" id="fecha" name="fecha" value="{{ old('fecha') }}" min="{{ date('Y-m-d') }}" required>
                    </div>
                    
                    <div class="filter-group">
                        <label for="hora">Hora de reserva *</label>
                        <select id="hora" name="hora" required>
                            <option value="">Selecciona una hora...</option>
                            <option value="12:00" {{ old('hora') == '12:00' ? 'selected' : '' }}>12:00 PM</option>
                            <option value="12:30" {{ old('hora') == '12:30' ? 'selected' : '' }}>12:30 PM</option>
                            <option value="13:00" {{ old('hora') == '13:00' ? 'selected' : '' }}>1:00 PM</option>
                            <option value="13:30" {{ old('hora') == '13:30' ? 'selected' : '' }}>1:30 PM</option>
                            <option value="14:00" {{ old('hora') == '14:00' ? 'selected' : '' }}>2:00 PM</option>
                            <option value="18:00" {{ old('hora') == '18:00' ? 'selected' : '' }}>6:00 PM</option>
                            <option value="18:30" {{ old('hora') == '18:30' ? 'selected' : '' }}>6:30 PM</option>
                            <option value="19:00" {{ old('hora') == '19:00' ? 'selected' : '' }}>7:00 PM</option>
                            <option value="19:30" {{ old('hora') == '19:30' ? 'selected' : '' }}>7:30 PM</option>
                            <option value="20:00" {{ old('hora') == '20:00' ? 'selected' : '' }}>8:00 PM</option>
                            <option value="20:30" {{ old('hora') == '20:30' ? 'selected' : '' }}>8:30 PM</option>
                            <option value="21:00" {{ old('hora') == '21:00' ? 'selected' : '' }}>9:00 PM</option>
                        </select>
                    </div>
                </div>

                <div class="filter-row" style="margin-bottom: 20px;">
                    <div class="filter-group">
                        <label for="motivo">Motivo de la reserva</label>
                        <select id="motivo" name="motivo">
                            <option value="">Selecciona un motivo...</option>
                            <option value="Cumpleaños" {{ old('motivo') == 'Cumpleaños' ? 'selected' : '' }}>Cumpleaños</option>
                            <option value="Aniversario" {{ old('motivo') == 'Aniversario' ? 'selected' : '' }}>Aniversario</option>
                            <option value="Cena romántica" {{ old('motivo') == 'Cena romántica' ? 'selected' : '' }}>Cena romántica</option>
                            <option value="Reunión de trabajo" {{ old('motivo') == 'Reunión de trabajo' ? 'selected' : '' }}>Reunión de trabajo</option>
                            <option value="Celebración familiar" {{ old('motivo') == 'Celebración familiar' ? 'selected' : '' }}>Celebración familiar</option>
                            <option value="Otro" {{ old('motivo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                </div>

                <div class="filter-group" style="margin-bottom: 30px;">
                    <label for="nota">Comentarios adicionales</label>
                    <textarea id="nota" name="nota" rows="4" placeholder="Alguna solicitud especial, alergias alimentarias, etc." style="width: 100%; padding: 12px; border: 2px solid #ffd700; border-radius: 8px; background-color: rgba(255, 255, 255, 0.9); color: #2c1810; resize: vertical;">{{ old('nota') }}</textarea>
                </div>

                <div style="text-align: center;">
                    <button type="submit" class="btn btn-primary" style="padding: 15px 40px; font-size: 1.1rem;">
                        <i class="fas fa-calendar-check"></i> Confirmar Reserva
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection