@extends('layouts.menu')

@section('title', 'Reportes - Olla y Sazón')

@section('content')
<div class="reportes-container">
    <div class="reportes-header">
        <h1 class="reportes-title">
            <i class="fas fa-chart-bar"></i>
            Reportes y Estadísticas - <span style="color: #000000 !important;">Olla y Sazón</span>
        </h1>
        <p class="reportes-subtitle" style="color: #000000 !important;">
            Análisis y métricas del restaurante
        </p>
    </div>

    <!-- Tarjetas de estadísticas rápidas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-utensils"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">8</h3>
                <p class="stat-label">Productos en Menú</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-chair"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">1</h3>
                <p class="stat-label">Mesas Disponibles</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">3</h3>
                <p class="stat-label">Usuarios Registrados</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">0</h3>
                <p class="stat-label">Pedidos Realizados</p>
            </div>
        </div>
    </div>

    <!-- Sección de reportes disponibles -->
    <div class="reportes-section">
        <h2 class="section-title">
            <i class="fas fa-file-alt"></i>
            Reportes Disponibles
        </h2>

        <div class="reportes-grid">
            <div class="reporte-card">
                <div class="reporte-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="reporte-content">
                    <h3 class="reporte-title">Productos Más Vendidos</h3>
                    <p class="reporte-description">Análisis de los productos con mayor demanda</p>
                    <button class="btn-reporte" onclick="mostrarReporte('productos')">
                        <i class="fas fa-eye"></i> Ver Reporte
                    </button>
                </div>
            </div>

            <div class="reporte-card">
                <div class="reporte-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="reporte-content">
                    <h3 class="reporte-title">Ventas por Período</h3>
                    <p class="reporte-description">Ingresos diarios, semanales y mensuales</p>
                    <button class="btn-reporte" onclick="mostrarReporte('ventas')">
                        <i class="fas fa-eye"></i> Ver Reporte
                    </button>
                </div>
            </div>

            <div class="reporte-card">
                <div class="reporte-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="reporte-content">
                    <h3 class="reporte-title">Horarios Pico</h3>
                    <p class="reporte-description">Análisis de horas con mayor actividad</p>
                    <button class="btn-reporte" onclick="mostrarReporte('horarios')">
                        <i class="fas fa-eye"></i> Ver Reporte
                    </button>
                </div>
            </div>

            <div class="reporte-card">
                <div class="reporte-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="reporte-content">
                    <h3 class="reporte-title">Satisfacción del Cliente</h3>
                    <p class="reporte-description">Métricas de calidad y servicio</p>
                    <button class="btn-reporte" onclick="mostrarReporte('satisfaccion')">
                        <i class="fas fa-eye"></i> Ver Reporte
                    </button>
                </div>
            </div>

            <div class="reporte-card">
                <div class="reporte-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="reporte-content">
                    <h3 class="reporte-title">Control de Inventario</h3>
                    <p class="reporte-description">Stock y productos con bajo inventario</p>
                    <button class="btn-reporte" onclick="mostrarReporte('inventario')">
                        <i class="fas fa-eye"></i> Ver Reporte
                    </button>
                </div>
            </div>

            <div class="reporte-card">
                <div class="reporte-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="reporte-content">
                    <h3 class="reporte-title">Análisis Financiero</h3>
                    <p class="reporte-description">Ingresos, gastos y rentabilidad</p>
                    <button class="btn-reporte" onclick="mostrarReporte('financiero')">
                        <i class="fas fa-eye"></i> Ver Reporte
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal de reporte -->
<div id="reporteModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-chart-bar"></i> <span id="reporteTitulo">Reporte</span></h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <div id="reporteContenido">
                <!-- Contenido dinámico -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.reportes-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
}

.reportes-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    border-radius: 20px;
    border: 2px solid var(--color-primary);
}

.reportes-title {
    font-size: 2.5rem;
    color: #000000 !important;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.reportes-subtitle {
    font-size: 1.1rem;
    color: #000000 !important;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.stat-card {
    background: var(--bg-glass);
    border: 2px solid var(--color-primary);
    border-radius: 15px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.3);
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: var(--color-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #000;
    font-size: 1.5rem;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: var(--color-primary);
    margin: 0;
}

.stat-label {
    color: var(--text-muted);
    margin: 0;
    font-size: 0.9rem;
}

.section-title {
    color: var(--color-primary);
    font-size: 1.8rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.reportes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.reporte-card {
    background: var(--bg-glass);
    border: 2px solid var(--color-primary);
    border-radius: 20px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    text-align: center;
}

.reporte-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.3);
}

.reporte-icon {
    width: 80px;
    height: 80px;
    background: var(--color-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #000;
    font-size: 2rem;
    margin: 0 auto 1rem;
}

.reporte-title {
    color: var(--color-primary);
    font-size: 1.3rem;
    margin-bottom: 0.5rem;
}

.reporte-description {
    color: var(--text-muted);
    margin-bottom: 1.5rem;
    line-height: 1.5;
}

.btn-reporte {
    background: var(--color-primary);
    color: #000;
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-reporte:hover {
    background: var(--color-primary-light);
    transform: translateY(-2px);
}



.modal {
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: var(--bg-glass);
    border-radius: 20px;
    max-width: 800px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    border: 2px solid var(--color-primary);
}

.modal-header {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
    color: #000;
    padding: 1.5rem;
    border-radius: 18px 18px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.close-modal {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #000;
    font-weight: bold;
}

.modal-body {
    padding: 2rem;
}

.reporte-tabla {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.reporte-tabla th,
.reporte-tabla td {
    padding: 0.8rem;
    text-align: left;
    border-bottom: 1px solid rgba(255, 215, 0, 0.3);
}

.reporte-tabla th {
    background: rgba(255, 215, 0, 0.1);
    color: var(--color-primary);
    font-weight: 600;
}

.reporte-tabla td {
    color: var(--text-light);
}

.reporte-grafico {
    text-align: center;
    padding: 2rem;
    background: rgba(255, 215, 0, 0.05);
    border-radius: 10px;
    margin: 1rem 0;
}

@media (max-width: 768px) {
    .reportes-container {
        padding: 1rem;
    }
    
    .reportes-title {
        font-size: 2rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .reportes-grid {
        grid-template-columns: 1fr;
    }
    
    .modal-content {
        width: 95%;
        max-height: 90vh;
    }
}
</style>
@endpush

@push('scripts')
<script>
const reportesData = {
    productos: {
        titulo: 'Productos Más Vendidos',
        contenido: `
            <div class="reporte-grafico">
                <i class="fas fa-chart-pie" style="font-size: 3rem; color: var(--color-primary); margin-bottom: 1rem;"></i>
                <h4>Top 5 Productos</h4>
            </div>
            <table class="reporte-tabla">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Ventas</th>
                        <th>Ingresos</th>
                        <th>Tendencia</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ajiaco Santafereño</td>
                        <td>45 unidades</td>
                        <td>$810,000</td>
                        <td style="color: #51cf66;"><i class="fas fa-arrow-up"></i> +15%</td>
                    </tr>
                    <tr>
                        <td>Bandeja Paisa</td>
                        <td>38 unidades</td>
                        <td>$1,064,000</td>
                        <td style="color: #51cf66;"><i class="fas fa-arrow-up"></i> +8%</td>
                    </tr>
                    <tr>
                        <td>Sancocho de Gallina</td>
                        <td>32 unidades</td>
                        <td>$640,000</td>
                        <td style="color: #ffa500;"><i class="fas fa-minus"></i> 0%</td>
                    </tr>
                    <tr>
                        <td>Arepa con Queso</td>
                        <td>28 unidades</td>
                        <td>$280,000</td>
                        <td style="color: #ff4757;"><i class="fas fa-arrow-down"></i> -5%</td>
                    </tr>
                    <tr>
                        <td>Jugo Natural</td>
                        <td>25 unidades</td>
                        <td>$125,000</td>
                        <td style="color: #51cf66;"><i class="fas fa-arrow-up"></i> +12%</td>
                    </tr>
                </tbody>
            </table>
        `
    },
    ventas: {
        titulo: 'Ventas por Período',
        contenido: `
            <div class="reporte-grafico">
                <i class="fas fa-calendar-alt" style="font-size: 3rem; color: var(--color-primary); margin-bottom: 1rem;"></i>
                <h4>Resumen de Ventas - Últimos 7 días</h4>
            </div>
            <table class="reporte-tabla">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Pedidos</th>
                        <th>Ingresos</th>
                        <th>Promedio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Hoy</td>
                        <td>12 pedidos</td>
                        <td>$480,000</td>
                        <td>$40,000</td>
                    </tr>
                    <tr>
                        <td>Ayer</td>
                        <td>15 pedidos</td>
                        <td>$675,000</td>
                        <td>$45,000</td>
                    </tr>
                    <tr>
                        <td>Hace 2 días</td>
                        <td>18 pedidos</td>
                        <td>$720,000</td>
                        <td>$40,000</td>
                    </tr>
                    <tr>
                        <td>Hace 3 días</td>
                        <td>10 pedidos</td>
                        <td>$350,000</td>
                        <td>$35,000</td>
                    </tr>
                    <tr>
                        <td>Hace 4 días</td>
                        <td>14 pedidos</td>
                        <td>$560,000</td>
                        <td>$40,000</td>
                    </tr>
                </tbody>
            </table>
        `
    },
    horarios: {
        titulo: 'Horarios Pico',
        contenido: `
            <div class="reporte-grafico">
                <i class="fas fa-clock" style="font-size: 3rem; color: var(--color-primary); margin-bottom: 1rem;"></i>
                <h4>Actividad por Horas</h4>
            </div>
            <table class="reporte-tabla">
                <thead>
                    <tr>
                        <th>Horario</th>
                        <th>Pedidos Promedio</th>
                        <th>Ocupación</th>
                        <th>Recomendación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>12:00 - 14:00</td>
                        <td>25 pedidos</td>
                        <td style="color: #ff4757;">95% - Muy Alto</td>
                        <td>Hora pico - Más personal</td>
                    </tr>
                    <tr>
                        <td>19:00 - 21:00</td>
                        <td>22 pedidos</td>
                        <td style="color: #ffa500;">85% - Alto</td>
                        <td>Hora pico - Preparación extra</td>
                    </tr>
                    <tr>
                        <td>15:00 - 17:00</td>
                        <td>8 pedidos</td>
                        <td style="color: #51cf66;">35% - Bajo</td>
                        <td>Ideal para mantenimiento</td>
                    </tr>
                    <tr>
                        <td>21:00 - 23:00</td>
                        <td>12 pedidos</td>
                        <td style="color: #51cf66;">50% - Medio</td>
                        <td>Horario normal</td>
                    </tr>
                </tbody>
            </table>
        `
    },
    satisfaccion: {
        titulo: 'Satisfacción del Cliente',
        contenido: `
            <div class="reporte-grafico">
                <i class="fas fa-star" style="font-size: 3rem; color: var(--color-primary); margin-bottom: 1rem;"></i>
                <h4>Calificaciones y Comentarios</h4>
                <p style="color: var(--color-primary); font-size: 2rem; margin: 1rem 0;">4.8/5.0 ⭐</p>
            </div>
            <table class="reporte-tabla">
                <thead>
                    <tr>
                        <th>Aspecto</th>
                        <th>Calificación</th>
                        <th>Comentarios</th>
                        <th>Tendencia</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Calidad de Comida</td>
                        <td>4.9/5.0</td>
                        <td>"Deliciosa y auténtica"</td>
                        <td style="color: #51cf66;"><i class="fas fa-arrow-up"></i> +0.2</td>
                    </tr>
                    <tr>
                        <td>Servicio al Cliente</td>
                        <td>4.7/5.0</td>
                        <td>"Muy amables y rápidos"</td>
                        <td style="color: #51cf66;"><i class="fas fa-arrow-up"></i> +0.1</td>
                    </tr>
                    <tr>
                        <td>Tiempo de Entrega</td>
                        <td>4.6/5.0</td>
                        <td>"Puntual y caliente"</td>
                        <td style="color: #ffa500;"><i class="fas fa-minus"></i> 0.0</td>
                    </tr>
                    <tr>
                        <td>Presentación</td>
                        <td>4.8/5.0</td>
                        <td>"Muy bien presentado"</td>
                        <td style="color: #51cf66;"><i class="fas fa-arrow-up"></i> +0.3</td>
                    </tr>
                </tbody>
            </table>
        `
    },
    inventario: {
        titulo: 'Control de Inventario',
        contenido: `
            <div class="reporte-grafico">
                <i class="fas fa-boxes" style="font-size: 3rem; color: var(--color-primary); margin-bottom: 1rem;"></i>
                <h4>Estado del Inventario</h4>
            </div>
            <table class="reporte-tabla">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Stock Actual</th>
                        <th>Stock Mínimo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ajiaco Santafereño</td>
                        <td>30 unidades</td>
                        <td>10 unidades</td>
                        <td style="color: #51cf66;"><i class="fas fa-check"></i> Normal</td>
                    </tr>
                    <tr>
                        <td>Bandeja Paisa</td>
                        <td>8 unidades</td>
                        <td>15 unidades</td>
                        <td style="color: #ffa500;"><i class="fas fa-exclamation"></i> Bajo</td>
                    </tr>
                    <tr>
                        <td>Sancocho de Gallina</td>
                        <td>25 unidades</td>
                        <td>12 unidades</td>
                        <td style="color: #51cf66;"><i class="fas fa-check"></i> Normal</td>
                    </tr>
                    <tr>
                        <td>Arepa con Queso</td>
                        <td>3 unidades</td>
                        <td>20 unidades</td>
                        <td style="color: #ff4757;"><i class="fas fa-times"></i> Crítico</td>
                    </tr>
                    <tr>
                        <td>Jugo Natural</td>
                        <td>45 unidades</td>
                        <td>25 unidades</td>
                        <td style="color: #51cf66;"><i class="fas fa-check"></i> Normal</td>
                    </tr>
                </tbody>
            </table>
        `
    },
    financiero: {
        titulo: 'Análisis Financiero',
        contenido: `
            <div class="reporte-grafico">
                <i class="fas fa-dollar-sign" style="font-size: 3rem; color: var(--color-primary); margin-bottom: 1rem;"></i>
                <h4>Resumen Financiero - Este Mes</h4>
            </div>
            <table class="reporte-tabla">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Monto</th>
                        <th>Porcentaje</th>
                        <th>Vs. Mes Anterior</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ingresos Totales</td>
                        <td>$15,480,000</td>
                        <td>100%</td>
                        <td style="color: #51cf66;"><i class="fas fa-arrow-up"></i> +12%</td>
                    </tr>
                    <tr>
                        <td>Costos de Ingredientes</td>
                        <td>$4,644,000</td>
                        <td>30%</td>
                        <td style="color: #51cf66;"><i class="fas fa-arrow-up"></i> +8%</td>
                    </tr>
                    <tr>
                        <td>Gastos Operativos</td>
                        <td>$3,096,000</td>
                        <td>20%</td>
                        <td style="color: #ffa500;"><i class="fas fa-minus"></i> 0%</td>
                    </tr>
                    <tr>
                        <td>Utilidad Bruta</td>
                        <td>$7,740,000</td>
                        <td>50%</td>
                        <td style="color: #51cf66;"><i class="fas fa-arrow-up"></i> +15%</td>
                    </tr>
                </tbody>
            </table>
        `
    }
};

function mostrarReporte(tipo) {
    const modal = document.getElementById('reporteModal');
    const titulo = document.getElementById('reporteTitulo');
    const contenido = document.getElementById('reporteContenido');
    
    const reporte = reportesData[tipo];
    if (reporte) {
        titulo.textContent = reporte.titulo;
        contenido.innerHTML = reporte.contenido;
        modal.style.display = 'flex';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('reporteModal');
    const closeButtons = document.querySelectorAll('.close-modal');
    
    closeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    });

    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>
@endpush

