package com.Ros.exe.Impl;

import com.Ros.exe.DTO.ReservaDto;
import com.Ros.exe.Entity.Reserva;
import com.Ros.exe.Entity.User;
import com.Ros.exe.Entity.Mesa;
import com.Ros.exe.Repository.ReservaRepository;
import com.Ros.exe.Repository.UserRepository;
import com.Ros.exe.Repository.MesaRepository;
import com.Ros.exe.Service.ReservaService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Date;
import java.util.List;
import java.util.stream.Collectors;

@Service
public class ReservaServiceImpl implements ReservaService {

    @Autowired
    private ReservaRepository reservaRepository;

    @Autowired
    private UserRepository userRepository;

    @Autowired
    private MesaRepository mesaRepository;
    
    @Autowired
    private ModelMapper modelMapper;

    @Override
    public ReservaDto crearReserva(ReservaDto reservaDto) {
        try {
            Reserva reserva = new Reserva();
            
            // Buscar usuario
            User user = userRepository.findById(reservaDto.getUserId() != null ? reservaDto.getUserId() : 1L)
                    .orElse(userRepository.findAll().stream().findFirst().orElse(null));
            if (user == null) {
                throw new RuntimeException("No hay usuarios disponibles");
            }
            
            // Buscar mesa disponible
            Mesa mesa = mesaRepository.findById(reservaDto.getMesaId() != null ? reservaDto.getMesaId() : 1L)
                    .orElse(mesaRepository.findAll().stream().findFirst().orElse(null));
            if (mesa == null) {
                throw new RuntimeException("No hay mesas disponibles");
            }
            
            reserva.setUser(user);
            reserva.setMesa(mesa);
            reserva.setFechaReserva(reservaDto.getFechaReserva() != null ? reservaDto.getFechaReserva() : new Date());
            reserva.setHora(reservaDto.getHora() != null ? reservaDto.getHora() : "12:00");
            reserva.setNumeroPersonas(reservaDto.getNumeroPersonas() > 0 ? reservaDto.getNumeroPersonas() : 2);
            reserva.setEstado(reservaDto.getEstado() != null ? reservaDto.getEstado().toUpperCase() : "PENDIENTE");
            reserva.setFechaCreacion(new Date());
            reserva.setFechaActualizacion(new Date());
            
            Reserva guardada = reservaRepository.save(reserva);
            return convertirAReservaDto(guardada);
        } catch (Exception e) {
            throw new RuntimeException("Error al crear reserva: " + e.getMessage());
        }
    }

    @Override
    public List<ReservaDto> listarReservas() {
        try {
            List<Reserva> reservas = reservaRepository.findAll();
            return reservas.stream()
                    .map(this::convertirAReservaDto)
                    .collect(Collectors.toList());
        } catch (Exception e) {
            return new java.util.ArrayList<>();
        }
    }

    @Override
    public ReservaDto actualizarReserva(Long idReserva, ReservaDto reservaDto) {
        Reserva reserva = reservaRepository.findById(idReserva)
                .orElseThrow(() -> new RuntimeException("Reserva no encontrada"));

        if (reservaDto.getFechaReserva() != null) {
            reserva.setFechaReserva(reservaDto.getFechaReserva());
        }
        if (reservaDto.getHora() != null) {
            reserva.setHora(reservaDto.getHora());
        }
        if (reservaDto.getNumeroPersonas() > 0) {
            reserva.setNumeroPersonas(reservaDto.getNumeroPersonas());
        }
        if (reservaDto.getEstado() != null) {
            reserva.setEstado(reservaDto.getEstado().toUpperCase());
        }

        if (reservaDto.getUserId() != null) {
            User user = userRepository.findById(reservaDto.getUserId())
                    .orElseThrow(() -> new RuntimeException("Usuario no encontrado"));
            reserva.setUser(user);
        }

        if (reservaDto.getMesaId() != null) {
            Mesa mesa = mesaRepository.findById(reservaDto.getMesaId())
                    .orElseThrow(() -> new RuntimeException("Mesa no encontrada"));
            reserva.setMesa(mesa);
        }

        reserva.setFechaActualizacion(new Date());

        Reserva actualizada = reservaRepository.save(reserva);
        return convertirAReservaDto(actualizada);
    }

    @Override
    public void eliminarReserva(Long idReserva) {
        Reserva reserva = reservaRepository.findById(idReserva)
                .orElseThrow(() -> new RuntimeException("Reserva no encontrada"));
        reservaRepository.delete(reserva);
    }

    @Override
    public ReservaDto obtenerPorId(Long id) {
        try {
            Reserva reserva = reservaRepository.findById(id)
                    .orElse(null);
            return reserva != null ? convertirAReservaDto(reserva) : null;
        } catch (Exception e) {
            throw new RuntimeException("Error al obtener reserva: " + e.getMessage());
        }
    }

    @Override
    public ReservaDto crearReservaPublica(String nombre, String telefono, String email, String fecha, String hora, Integer personas, String comentarios, Long userId) {
        try {
            User user = userRepository.findById(userId)
                    .orElseThrow(() -> new RuntimeException("Usuario no encontrado"));
            
            // Buscar una mesa disponible para el número de personas
            Mesa mesa = mesaRepository.findAll().stream()
                    .filter(m -> m.getCapacidad() >= personas)
                    .findFirst()
                    .orElseThrow(() -> new RuntimeException("No hay mesas disponibles para " + personas + " personas"));
            
            Reserva reserva = new Reserva();
            reserva.setUser(user);
            reserva.setMesa(mesa);
            reserva.setEstado("CONFIRMADA");
            reserva.setFechaCreacion(new Date());
            reserva.setFechaActualizacion(new Date());
            
            // Parsear fecha y hora (simplificado)
            java.sql.Date fechaReserva = java.sql.Date.valueOf(fecha);
            reserva.setFechaReserva(fechaReserva);
            
            Reserva guardada = reservaRepository.save(reserva);
            return convertirAReservaDto(guardada);
        } catch (Exception e) {
            throw new RuntimeException("Error al crear la reserva: " + e.getMessage(), e);
        }
    }
    
    private ReservaDto convertirAReservaDto(Reserva reserva) {
        ReservaDto dto = new ReservaDto();
        dto.setId(reserva.getId());
        dto.setFechaReserva(reserva.getFechaReserva());
        dto.setHora(reserva.getHora());
        dto.setNumeroPersonas(reserva.getNumeroPersonas());
        dto.setEstado(reserva.getEstado());
        dto.setFechaCreacion(reserva.getFechaCreacion());
        dto.setFechaActualizacion(reserva.getFechaActualizacion());
        
        if (reserva.getUser() != null) {
            dto.setUserId(reserva.getUser().getIdUser());
        }
        if (reserva.getMesa() != null) {
            dto.setMesaId(reserva.getMesa().getIdMesa());
        }
        return dto;
    }
}
