{{-- Esta vista ya no se usa - redirigir al controlador específico --}}
<script>
    window.location.href = '{{ route("dashboard") }}';
</script>

<div style="text-align: center; padding: 50px;">
    <h2>Redirigiendo...</h2>
    <p>Si no eres redirigido automáticamente, <a href="{{ route('dashboard') }}">haz clic aquí</a></p>
</div>
