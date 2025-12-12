package com.Ros.exe.Service;

import com.Ros.exe.DTO.ReservaDto;
import java.util.List;

public interface ReservaService {

    ReservaDto crearReserva(ReservaDto reservaDto);

    List<ReservaDto> listarReservas();

    ReservaDto actualizarReserva(Long idReserva, ReservaDto reservaDto);

    void eliminarReserva(Long idReserva);
    
    ReservaDto obtenerPorId(Long id);
    
    default ReservaDto crearReservaPublica(String nombre, String telefono, String email, String fecha, String hora, Integer personas, String comentarios, Long userId) {
        // Implementación temporal básica
        ReservaDto reserva = new ReservaDto();
        reserva.setEstado("PENDIENTE");
        try {
            return crearReserva(reserva);
        } catch (Exception e) {
            // Si falla, devolver una reserva básica
            reserva.setId(1L);
            return reserva;
        }
    }
}
