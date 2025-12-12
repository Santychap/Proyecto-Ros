package com.Ros.exe.Controller;

import com.Ros.exe.DTO.ReservaDto;
import com.Ros.exe.Service.ReservaService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@Controller
public class ReservaController {

    @Autowired
    private ReservaService reservaService;

    @GetMapping("/reservas")
    public String listar(@RequestParam(required = false) String estado,
                        @RequestParam(required = false) Long userId,
                        @RequestParam(required = false) Long mesaId,
                        Model model) {
        try {
            List<ReservaDto> reservas = reservaService.listarReservas();
            
            if (estado != null && !estado.trim().isEmpty()) {
                reservas = reservas.stream()
                    .filter(r -> estado.equalsIgnoreCase(r.getEstado()))
                    .collect(java.util.stream.Collectors.toList());
            }
            if (userId != null) {
                reservas = reservas.stream()
                    .filter(r -> userId.equals(r.getUserId()))
                    .collect(java.util.stream.Collectors.toList());
            }
            if (mesaId != null) {
                reservas = reservas.stream()
                    .filter(r -> mesaId.equals(r.getMesaId()))
                    .collect(java.util.stream.Collectors.toList());
            }
            
            model.addAttribute("reservas", reservas);
            model.addAttribute("estadoFiltro", estado);
            model.addAttribute("userIdFiltro", userId);
            model.addAttribute("mesaIdFiltro", mesaId);
            return "reserva/list";
        } catch (Exception e) {
            model.addAttribute("error", "Error al cargar reservas: " + e.getMessage());
            model.addAttribute("reservas", java.util.Collections.emptyList());
            return "reserva/list";
        }
    }

    @GetMapping("/reservas/new")
    public String nuevo(Model model) {
        ReservaDto reserva = new ReservaDto();
        reserva.setUserId(1L);
        reserva.setMesaId(1L);
        reserva.setNumeroPersonas(2);
        reserva.setEstado("PENDIENTE");
        model.addAttribute("reserva", reserva);
        return "reserva/form";
    }

    @GetMapping("/reservas/edit/{id}")
    public String editar(@PathVariable Long id, Model model) {
        ReservaDto reserva = reservaService.obtenerPorId(id);
        if (reserva == null) {
            return "redirect:/reservas";
        }
        model.addAttribute("reserva", reserva);
        return "reserva/form";
    }

    @PostMapping("/reservas/save")
    public String guardar(@ModelAttribute ReservaDto reserva, Model model) {
        try {
            if (reserva.getId() == null) {
                reservaService.crearReserva(reserva);
            } else {
                reservaService.actualizarReserva(reserva.getId(), reserva);
            }
            return "redirect:/reservas";
        } catch (Exception e) {
            model.addAttribute("error", "Error al guardar la reserva: " + e.getMessage());
            model.addAttribute("reserva", reserva);
            return "reserva/form";
        }
    }

    @PostMapping("/reservas/delete/{id}")
    public String eliminar(@PathVariable Long id) {
        reservaService.eliminarReserva(id);
        return "redirect:/reservas";
    }

    @PostMapping("/api/reservas")
    @ResponseBody
    public ResponseEntity<?> crearReserva(@RequestBody ReservaDto reservaDto) {
        try {
            ReservaDto nuevaReserva = reservaService.crearReserva(reservaDto);
            return new ResponseEntity<>(nuevaReserva, HttpStatus.CREATED);
        } catch (Exception e) {
            return new ResponseEntity<>("Error al crear la reserva: " + e.getMessage(), HttpStatus.BAD_REQUEST);
        }
    }

    @GetMapping("/api/reservas")
    @ResponseBody
    public ResponseEntity<?> listarReservasApi() {
        try {
            List<ReservaDto> reservas = reservaService.listarReservas();
            return new ResponseEntity<>(reservas, HttpStatus.OK);
        } catch (Exception e) {
            return new ResponseEntity<>("Error al listar las reservas: " + e.getMessage(), HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }

    @PutMapping("/api/reservas/{id}")
    @ResponseBody
    public ResponseEntity<?> actualizarReserva(@PathVariable Long id, @RequestBody ReservaDto reservaDto) {
        try {
            ReservaDto actualizada = reservaService.actualizarReserva(id, reservaDto);
            return new ResponseEntity<>(actualizada, HttpStatus.OK);
        } catch (Exception e) {
            return new ResponseEntity<>("Error al actualizar la reserva: " + e.getMessage(), HttpStatus.BAD_REQUEST);
        }
    }

    @DeleteMapping("/api/reservas/{id}")
    @ResponseBody
    public ResponseEntity<?> eliminarReserva(@PathVariable Long id) {
        try {
            reservaService.eliminarReserva(id);
            return new ResponseEntity<>("Reserva eliminada correctamente.", HttpStatus.OK);
        } catch (Exception e) {
            return new ResponseEntity<>("Error al eliminar la reserva: " + e.getMessage(), HttpStatus.BAD_REQUEST);
        }
    }
}
