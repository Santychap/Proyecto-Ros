package com.Ros.exe.Controller;

import com.Ros.exe.DTO.UserDto;
import com.Ros.exe.Service.UserService;
import com.Ros.exe.Service.RolService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.security.core.Authentication;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import java.util.List;

@Controller
public class UserController {

    @Autowired
    private UserService userService;
    
    @Autowired
    private RolService rolService;
    
    @Autowired
    private com.Ros.exe.Repository.PedidoRepository pedidoRepository;
    
    @Autowired
    private com.Ros.exe.Repository.ReservaRepository reservaRepository;
    
    @Autowired
    private com.Ros.exe.Repository.UserRepository userRepository;

    // Vistas Web
    @GetMapping("/users")
    public String listar(@RequestParam(required = false) String nombre,
                        @RequestParam(required = false) String email,
                        @RequestParam(required = false) Long rolId,
                        @RequestParam(required = false) Boolean activo,
                        Model model) {
        List<UserDto> users = userService.listarUser();
        
        // Filtrar por nombre
        if (nombre != null && !nombre.isEmpty()) {
            users = users.stream()
                .filter(u -> (u.getNombre() != null && u.getNombre().toLowerCase().contains(nombre.toLowerCase())) ||
                           (u.getApellido() != null && u.getApellido().toLowerCase().contains(nombre.toLowerCase())))
                .collect(java.util.stream.Collectors.toList());
        }
        
        // Filtrar por email
        if (email != null && !email.isEmpty()) {
            users = users.stream()
                .filter(u -> u.getEmail() != null && u.getEmail().toLowerCase().contains(email.toLowerCase()))
                .collect(java.util.stream.Collectors.toList());
        }
        
        // Filtrar por rol
        if (rolId != null) {
            users = users.stream()
                .filter(u -> u.getRolId() != null && u.getRolId().equals(rolId))
                .collect(java.util.stream.Collectors.toList());
        }
        
        // Filtrar por estado activo
        if (activo != null) {
            users = users.stream()
                .filter(u -> u.getActivo() == activo)
                .collect(java.util.stream.Collectors.toList());
        }
        
        model.addAttribute("users", users);
        model.addAttribute("roles", rolService.listarRol());
        model.addAttribute("nombreFiltro", nombre);
        model.addAttribute("emailFiltro", email);
        model.addAttribute("rolIdFiltro", rolId);
        model.addAttribute("activoFiltro", activo);
        return "users/list";
    }

    @GetMapping("/users/new")
    public String nuevo(Model model) {
        model.addAttribute("user", new UserDto());
        model.addAttribute("roles", rolService.listarRol());
        return "users/form";
    }

    @GetMapping("/users/edit/{id}")
    public String editar(@PathVariable Long id, Model model) {
        UserDto user = userService.obtenerPorId(id);
        if (user == null) {
            return "redirect:/users";
        }
        model.addAttribute("user", user);
        model.addAttribute("roles", rolService.listarRol());
        return "users/form";
    }

    @PostMapping("/users/save")
    public String guardar(@ModelAttribute UserDto user, RedirectAttributes redirect, Model model) {
        try {
            if (user.getIdUser() == null) {
                userService.crearUsuario(user);
                redirect.addFlashAttribute("success", "Usuario creado exitosamente");
            } else {
                userService.actualizarUser(user.getIdUser(), user);
                redirect.addFlashAttribute("success", "Usuario actualizado exitosamente");
            }
            return "redirect:/users";
        } catch (Exception e) {
            redirect.addFlashAttribute("error", "Error: El email ya existe o datos inválidos");
            return "redirect:/users/new";
        }
    }

    @PostMapping("/users/toggle/{id}")
    public String toggleActivo(@PathVariable Long id, RedirectAttributes redirect) {
        try {
            userService.toggleEstadoUsuario(id);
            redirect.addFlashAttribute("success", "Estado del usuario actualizado correctamente");
        } catch (Exception e) {
            redirect.addFlashAttribute("error", "Error al actualizar el estado del usuario");
        }
        return "redirect:/users";
    }

    // API REST
    @PostMapping("/api/users")
    @ResponseBody
    public ResponseEntity<UserDto> crearUsuario(@RequestBody UserDto userDto) {
        return ResponseEntity.ok(userService.crearUsuario(userDto));
    }

    @GetMapping("/api/users")
    @ResponseBody
    public ResponseEntity<List<UserDto>> listarUsuarios() {
        return ResponseEntity.ok(userService.listarUser());
    }

    @GetMapping("/api/users/{idUser}")
    @ResponseBody
    public ResponseEntity<UserDto> obtenerPorId(@PathVariable Long idUser) {
        UserDto user = userService.obtenerPorId(idUser);
        if (user == null) {
            return ResponseEntity.notFound().build();
        }
        return ResponseEntity.ok(user);
    }

    @PutMapping("/api/users/{idUser}")
    @ResponseBody
    public ResponseEntity<UserDto> actualizarUsuario(@PathVariable Long idUser, @RequestBody UserDto userDto) {
        UserDto existente = userService.obtenerPorId(idUser);
        if (existente == null) {
            return ResponseEntity.notFound().build();
        }
        UserDto actualizado = userService.actualizarUser(idUser, userDto);
        return ResponseEntity.ok(actualizado);
    }

    @DeleteMapping("/api/users/{idUser}")
    @ResponseBody
    public ResponseEntity<Void> eliminarUsuario(@PathVariable Long idUser) {
        UserDto existente = userService.obtenerPorId(idUser);
        if (existente == null) {
            return ResponseEntity.notFound().build();
        }
        userService.eliminarUsuario(idUser);
        return ResponseEntity.noContent().build();
    }

    // RUTAS PARA CLIENTE
    @GetMapping("/mi-perfil")
    public String miPerfil(Model model, Authentication auth) {
        String username = auth.getName();
        com.Ros.exe.Entity.User user = userRepository.findAll().stream()
            .filter(u -> u.getEmail() != null && u.getEmail().equals(username))
            .findFirst()
            .orElse(null);
        
        if (user != null) {
            UserDto userDto = new UserDto();
            userDto.setIdUser(user.getIdUser());
            userDto.setEmail(user.getEmail());
            userDto.setNombre(user.getNombre());
            userDto.setApellido(user.getApellido());
            model.addAttribute("user", userDto);
        } else {
            UserDto userDto = new UserDto();
            userDto.setEmail(username);
            userDto.setNombre("Cliente");
            userDto.setApellido("Demo");
            model.addAttribute("user", userDto);
        }
        return "cliente/perfil";
    }

    @PostMapping("/mi-perfil/actualizar")
    public String actualizarPerfil(@ModelAttribute UserDto user, RedirectAttributes redirect, Authentication auth) {
        try {
            String username = auth.getName();
            com.Ros.exe.Entity.User userEntity = userRepository.findAll().stream()
                .filter(u -> u.getEmail() != null && u.getEmail().equals(username))
                .findFirst()
                .orElse(null);
            
            if (userEntity != null) {
                userEntity.setNombre(user.getNombre());
                userEntity.setApellido(user.getApellido());
                userEntity.setFechaActualizacion(new java.util.Date());
                userRepository.save(userEntity);
                redirect.addFlashAttribute("success", "Perfil actualizado correctamente");
            } else {
                redirect.addFlashAttribute("error", "Usuario no encontrado");
            }
        } catch (Exception e) {
            redirect.addFlashAttribute("error", "Error al actualizar el perfil");
        }
        return "redirect:/mi-perfil";
    }

    @GetMapping("/mis-pedidos")
    public String misPedidos(Model model, Authentication auth) {
        String username = auth.getName();
        com.Ros.exe.Entity.User user = userRepository.findAll().stream()
            .filter(u -> u.getEmail() != null && u.getEmail().equals(username))
            .findFirst()
            .orElse(null);
        
        if (user != null) {
            java.util.List<com.Ros.exe.Entity.Pedido> pedidos = pedidoRepository.findAll().stream()
                .filter(p -> p.getUser() != null && p.getUser().getIdUser().equals(user.getIdUser()))
                .sorted((p1, p2) -> p2.getFechaCreacion().compareTo(p1.getFechaCreacion()))
                .collect(java.util.stream.Collectors.toList());
            
            long pendientes = pedidos.stream()
                .filter(p -> "Pendiente".equals(p.getEstado()) || "Preparando".equals(p.getEstado()))
                .count();
            long completados = pedidos.stream()
                .filter(p -> "Entregado".equals(p.getEstado()) || "Completado".equals(p.getEstado()))
                .count();
            double totalGastado = pedidos.stream()
                .mapToDouble(com.Ros.exe.Entity.Pedido::getTotal)
                .sum();
            
            model.addAttribute("pedidos", pedidos);
            model.addAttribute("pendientes", pendientes);
            model.addAttribute("completados", completados);
            model.addAttribute("totalGastado", totalGastado);
        } else {
            model.addAttribute("pedidos", java.util.Collections.emptyList());
            model.addAttribute("pendientes", 0);
            model.addAttribute("completados", 0);
            model.addAttribute("totalGastado", 0.0);
        }
        return "cliente/pedidos";
    }

    @GetMapping("/mis-reservas")
    public String misReservas(Model model, Authentication auth) {
        try {
            String username = auth.getName();
            com.Ros.exe.Entity.User user = userRepository.findAll().stream()
                .filter(u -> u.getEmail() != null && u.getEmail().equals(username))
                .findFirst()
                .orElse(null);
            
            if (user != null) {
                java.util.List<com.Ros.exe.Entity.Reserva> reservas = reservaRepository.findAll().stream()
                    .filter(r -> r.getUser() != null && r.getUser().getIdUser().equals(user.getIdUser()))
                    .collect(java.util.stream.Collectors.toList());
                
                long proximas = reservas.stream()
                    .filter(r -> "CONFIRMADA".equals(r.getEstado()) || "PENDIENTE".equals(r.getEstado()))
                    .count();
                long completadas = reservas.stream()
                    .filter(r -> "COMPLETADA".equals(r.getEstado()))
                    .count();
                long canceladas = reservas.stream()
                    .filter(r -> "CANCELADA".equals(r.getEstado()))
                    .count();
                
                model.addAttribute("reservas", reservas);
                model.addAttribute("proximas", proximas);
                model.addAttribute("completadas", completadas);
                model.addAttribute("canceladas", canceladas);
            } else {
                model.addAttribute("reservas", java.util.Collections.emptyList());
                model.addAttribute("proximas", 0);
                model.addAttribute("completadas", 0);
                model.addAttribute("canceladas", 0);
            }
        } catch (Exception e) {
            model.addAttribute("reservas", java.util.Collections.emptyList());
            model.addAttribute("proximas", 0);
            model.addAttribute("completadas", 0);
            model.addAttribute("canceladas", 0);
        }
        return "cliente/reservas";
    }

    @GetMapping("/mis-pagos")
    public String misPagos(Model model) {
        return "cliente/pagos";
    }


}
