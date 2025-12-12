package com.Ros.exe.Controller;

import com.Ros.exe.DTO.PedidoDto;
import com.Ros.exe.Entity.Pago;
import com.Ros.exe.Entity.User;
import com.Ros.exe.Repository.PagoRepository;
import com.Ros.exe.Service.PedidoService;
import com.Ros.exe.Repository.PedidoRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.security.core.Authentication;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;
import jakarta.persistence.EntityNotFoundException;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import java.util.Date;
import java.util.List;
import java.util.stream.Collectors;

@Controller
public class PedidoController {
    
    private static final Logger logger = LoggerFactory.getLogger(PedidoController.class);

    @Autowired
    private PedidoService pedidoService;
    
    @Autowired
    private PedidoRepository pedidoRepository;

    @Autowired
    private PagoRepository pagoRepository;

    // Vistas Web
    @GetMapping("/pedidos-asignados")
    public String pedidosAsignados(Model model) {
        java.util.List<java.util.Map<String, Object>> pedidos = new java.util.ArrayList<>();
        
        try {
            java.util.List<com.Ros.exe.Entity.Pedido> pedidosEntity = pedidoRepository.findAll();
            
            for (com.Ros.exe.Entity.Pedido p : pedidosEntity) {
                try {
                    if (p != null && p.getEstado() != null && 
                        ("SIN_CANCELAR".equals(p.getEstado()) || "PENDIENTE".equals(p.getEstado()) || "PAGADO".equals(p.getEstado()))) {
                        
                        java.util.Map<String, Object> pedido = new java.util.HashMap<>();
                        pedido.put("id", p.getId() != null ? p.getId() : 0L);
                        pedido.put("clienteNombre", p.getClienteNombre() != null ? p.getClienteNombre() : "Cliente");
                        pedido.put("numeroMesa", p.getNumeroMesa() != null ? p.getNumeroMesa() : "0");
                        pedido.put("total", p.getTotal());
                        pedido.put("estado", p.getEstado() != null ? p.getEstado() : "PENDIENTE");
                        pedido.put("fechaCreacion", p.getFechaCreacion() != null ? p.getFechaCreacion() : new java.util.Date());
                        
                        pedidos.add(pedido);
                    }
                } catch (Exception ex) {
                    // Saltar este pedido si hay error
                    continue;
                }
            }
        } catch (Exception e) {
            // Si hay error general, continuar con lista vacía
        }
        
        model.addAttribute("pedidos", pedidos);
        return "empleado/pedidos";
    }

    @GetMapping("/pedidos")
    public String listar(@RequestParam(required = false) String estado,
                        @RequestParam(required = false) Long userId,
                        @RequestParam(required = false) String numeroMesa,
                        @RequestParam(required = false) Double totalMin,
                        @RequestParam(required = false) Double totalMax,
                        Model model) {
        List<PedidoDto> pedidos = pedidoService.listarPedido();
        
        // Filtrar por estado
        if (estado != null && !estado.isEmpty()) {
            pedidos = pedidos.stream()
                .filter(p -> p.getEstado() != null && p.getEstado().equalsIgnoreCase(estado))
                .collect(Collectors.toList());
        }
        
        // Filtrar por usuario
        if (userId != null) {
            pedidos = pedidos.stream()
                .filter(p -> p.getUserId() != null && p.getUserId().equals(userId))
                .collect(Collectors.toList());
        }
        
        // Filtrar por mesa
        if (numeroMesa != null && !numeroMesa.isEmpty()) {
            pedidos = pedidos.stream()
                .filter(p -> p.getNumeroMesa() != null && p.getNumeroMesa().contains(numeroMesa))
                .collect(Collectors.toList());
        }
        
        // Filtrar por total mínimo
        if (totalMin != null) {
            pedidos = pedidos.stream()
                .filter(p -> p.getTotal() >= totalMin)
                .collect(Collectors.toList());
        }
        
        // Filtrar por total máximo
        if (totalMax != null) {
            pedidos = pedidos.stream()
                .filter(p -> p.getTotal() <= totalMax)
                .collect(Collectors.toList());
        }
        
        model.addAttribute("pedidos", pedidos);
        model.addAttribute("estadoFiltro", estado);
        model.addAttribute("userIdFiltro", userId);
        model.addAttribute("numeroMesaFiltro", numeroMesa);
        model.addAttribute("totalMinFiltro", totalMin);
        model.addAttribute("totalMaxFiltro", totalMax);
        return "pedido/list";
    }

    @GetMapping("/pedidos/new")
    public String nuevo(Model model) {
        model.addAttribute("pedido", new PedidoDto());
        return "pedido/form";
    }

    @GetMapping("/pedidos/edit/{id}")
    public String editar(@PathVariable Long id, Model model) {
        try {
            PedidoDto pedido = pedidoService.obtenerPedido(id);
            if (pedido == null) {
                return "redirect:/pedidos";
            }
            model.addAttribute("pedido", pedido);
            return "pedido/form";
        } catch (Exception e) {
            return "redirect:/pedidos";
        }
    }

    @PostMapping("/pedidos/save")
    public String guardar(@ModelAttribute PedidoDto pedido, RedirectAttributes redirect) {
        if (pedido.getId() == null) {
            pedidoService.crearPedido(pedido);
            redirect.addFlashAttribute("success", "Pedido creado exitosamente");
        } else {
            pedidoService.actualizarPedido(pedido.getId(), pedido);
            redirect.addFlashAttribute("success", "Pedido actualizado exitosamente");
        }
        return "redirect:/pedidos";
    }

    @PostMapping("/pedidos/delete/{id}")
    public String eliminar(@PathVariable Long id, RedirectAttributes redirect) {
        pedidoService.eliminarPedido(id);
        redirect.addFlashAttribute("success", "Pedido eliminado exitosamente");
        return "redirect:/pedidos";
    }

    // API REST
    @PostMapping("/api/pedidos")
    @ResponseBody
    public ResponseEntity<PedidoDto> crearPedido(@RequestBody PedidoDto pedidoDto) {
        if (pedidoDto == null) {
            return ResponseEntity.badRequest().build();
        }
        PedidoDto creado = pedidoService.crearPedido(pedidoDto);
        return ResponseEntity.ok(creado);
    }

    @GetMapping("/api/pedidos")
    @ResponseBody
    public ResponseEntity<List<PedidoDto>> listarPedidos() {
        List<PedidoDto> pedidos = pedidoService.listarPedido();
        if (pedidos.isEmpty()) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.ok(pedidos);
    }

    @GetMapping("/api/pedidos/{id}")
    @ResponseBody
    public ResponseEntity<PedidoDto> obtenerPedido(@PathVariable Long id) {
        try {
            PedidoDto pedido = pedidoService.obtenerPedido(id); // Llama al service que busca por ID
            return ResponseEntity.ok(pedido);
        } catch (EntityNotFoundException e) { // O tu ResourceNotFoundException si usas la personalizada
            return ResponseEntity.notFound().build();
        } catch (Exception e) {
            return ResponseEntity.internalServerError().build();
        }
    }


    @PutMapping("/api/pedidos/{id}")
    @ResponseBody
    public ResponseEntity<PedidoDto> actualizarPedido(@PathVariable Long id, @RequestBody PedidoDto pedidoDto) {
        if (pedidoDto == null) {
            return ResponseEntity.badRequest().build();
        }
        PedidoDto actualizado = pedidoService.actualizarPedido(id, pedidoDto);
        return ResponseEntity.ok(actualizado);
    }

    @DeleteMapping("/api/pedidos/{id}")
    @ResponseBody
    public ResponseEntity<Void> eliminarPedido(@PathVariable Long id) {
        boolean eliminado = pedidoService.eliminarPedido(id);
        if (!eliminado) {
            return ResponseEntity.notFound().build();
        }
        return ResponseEntity.noContent().build();
    }
    
    @PostMapping("/pedidos/cambiar-estado/{id}")
    public String cambiarEstado(@PathVariable Long id, @RequestParam String nuevoEstado, 
                               RedirectAttributes redirectAttributes, Authentication authentication) {
        try {
            com.Ros.exe.Entity.Pedido pedido = pedidoRepository.findById(id).orElseThrow(() -> new EntityNotFoundException("Pedido no encontrado"));
            
            if ("SIN_CANCELAR".equals(pedido.getEstado())) {
                if ("PAGADO".equals(nuevoEstado)) {
                    // 1. Actualizar estado del pedido
                    pedido.setEstado(nuevoEstado);
                    pedido.setFechaActualizacion(new Date());
                    pedidoRepository.save(pedido);

                    // 2. Crear el registro de pago en efectivo
                    Pago pago = new Pago();
                    pago.setPedido(pedido);
                    pago.setUser(pedido.getUser()); 
                    pago.setMetodoPago("Efectivo");
                    pago.setMontoTotal(pedido.getTotal());
                    pago.setEstado("completado");
                    pago.setFechaPago(new Date());
                    pago.setFechaCreacion(new Date());
                    pago.setFechaActualizacion(new Date());
                    pagoRepository.save(pago);

                    redirectAttributes.addFlashAttribute("success", "Estado actualizado a PAGADO y pago en efectivo registrado.");

                } else if ("CANCELADO".equals(nuevoEstado)) {
                    pedido.setEstado(nuevoEstado);
                    pedido.setFechaActualizacion(new Date());
                    pedidoRepository.save(pedido);
                    redirectAttributes.addFlashAttribute("success", "Estado actualizado a CANCELADO.");
                } else {
                    redirectAttributes.addFlashAttribute("error", "Estado nuevo no válido.");
                }
            } else {
                redirectAttributes.addFlashAttribute("error", "El pedido no se puede modificar porque no está en estado 'SIN_CANCELAR'.");
            }
        } catch (Exception e) {
            logger.error("Error al cambiar estado de pedido a {}: {}", nuevoEstado, e.getMessage());
            redirectAttributes.addFlashAttribute("error", "Error grave al actualizar el estado.");
        }
        
        // Redirigir según el rol
        boolean isAdmin = authentication.getAuthorities().stream()
                .anyMatch(a -> a.getAuthority().equals("ROLE_ADMINISTRADOR"));
        
        return isAdmin ? "redirect:/pedidos" : "redirect:/pedidos-asignados";
    }
}
