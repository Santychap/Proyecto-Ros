package com.Ros.exe.Controller;

import com.Ros.exe.DTO.RolDto;
import com.Ros.exe.Service.RolService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import java.util.List;

@Controller
public class RolController {

    @Autowired
    private RolService rolService;

    @GetMapping("/roles")
    public String listar(@RequestParam(required = false) String nombre, Model model) {
        List<RolDto> roles = rolService.listarRol();
        
        // Filtrar por nombre
        if (nombre != null && !nombre.isEmpty()) {
            roles = roles.stream()
                .filter(r -> r.getNombre() != null && r.getNombre().toLowerCase().contains(nombre.toLowerCase()))
                .collect(java.util.stream.Collectors.toList());
        }
        
        model.addAttribute("roles", roles);
        model.addAttribute("nombreFiltro", nombre);
        return "rol/list";
    }

    @GetMapping("/roles/new")
    public String nuevo(Model model) {
        model.addAttribute("rol", new RolDto());
        return "rol/form";
    }

    @GetMapping("/roles/edit/{id}")
    public String editar(@PathVariable Long id, Model model) {
        RolDto rol = rolService.obtenerPorId(id);
        if (rol == null) {
            return "redirect:/roles";
        }
        model.addAttribute("rol", rol);
        return "rol/form";
    }

    @PostMapping("/roles/save")
    public String guardar(@ModelAttribute RolDto rol, RedirectAttributes redirect) {
        if (rol.getIdRol() == null) {
            rolService.crearRol(rol);
            redirect.addFlashAttribute("success", "Rol creado exitosamente");
        } else {
            rolService.actualizarRol(rol.getIdRol(), rol);
            redirect.addFlashAttribute("success", "Rol actualizado exitosamente");
        }
        return "redirect:/roles";
    }

    @PostMapping("/roles/delete/{id}")
    public String eliminar(@PathVariable Long id, RedirectAttributes redirect) {
        rolService.eliminarRol(id);
        redirect.addFlashAttribute("success", "Rol eliminado exitosamente");
        return "redirect:/roles";
    }

    @PostMapping("/api/roles")
    @ResponseBody
    public ResponseEntity<RolDto> crearRol(@RequestBody RolDto rolDto) {
        RolDto creado = rolService.crearRol(rolDto);
        return ResponseEntity.ok(creado);
    }

    @GetMapping("/api/roles")
    @ResponseBody
    public ResponseEntity<List<RolDto>> listarRolesApi() {
        return ResponseEntity.ok(rolService.listarRol());
    }

    @GetMapping("/api/roles/{idRol}")
    @ResponseBody
    public ResponseEntity<RolDto> obtenerPorIdApi(@PathVariable Long idRol) {
        RolDto rol = rolService.obtenerPorId(idRol);
        if (rol == null) {
            return ResponseEntity.notFound().build();
        }
        return ResponseEntity.ok(rol);
    }

    @PutMapping("/api/roles/{idRol}")
    @ResponseBody
    public ResponseEntity<RolDto> actualizarRolApi(@PathVariable Long idRol, @RequestBody RolDto rolDto) {
        RolDto actualizado = rolService.actualizarRol(idRol, rolDto);
        if (actualizado == null) {
            return ResponseEntity.notFound().build();
        }
        return ResponseEntity.ok(actualizado);
    }

    @DeleteMapping("/api/roles/{idRol}")
    @ResponseBody
    public ResponseEntity<Void> eliminarRolApi(@PathVariable Long idRol) {
        boolean eliminado = rolService.eliminarRol(idRol);
        if (!eliminado) {
            return ResponseEntity.notFound().build();
        }
        return ResponseEntity.noContent().build();
    }
}
