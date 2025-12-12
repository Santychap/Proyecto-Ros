package com.Ros.exe.Controller;

import com.Ros.exe.DTO.HorarioDto;
import com.Ros.exe.Service.HorarioService;
import com.Ros.exe.Service.UserService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.security.core.Authentication;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import java.util.List;
import java.util.stream.Collectors;

@Controller
public class HorarioController {

    @Autowired
    private HorarioService horarioService;
    
    @Autowired
    private UserService userService;

    @GetMapping("/horarios")
    public String listar(Model model) {
        model.addAttribute("horarios", horarioService.listarHorario());
        return "horario/list";
    }

    @GetMapping("/mi-horario")
    public String miHorario(Model model) {
        try {
            List<HorarioDto> misHorarios = horarioService.listarHorario();
            model.addAttribute("horarios", misHorarios);
        } catch (Exception e) {
            model.addAttribute("horarios", java.util.Collections.emptyList());
        }
        return "empleado/mi-horario";
    }

    @GetMapping("/horarios/new")
    public String nuevo(Model model) {
        model.addAttribute("horario", new HorarioDto());
        // Obtener solo empleados (usuarios con rol EMPLEADO)
        model.addAttribute("empleados", userService.listarUser().stream()
                .filter(u -> u.getRol() != null && "EMPLEADO".equals(u.getRol().getNombre()))
                .collect(Collectors.toList()));
        return "horario/form";
    }

    @GetMapping("/horarios/edit/{id}")
    public String editar(@PathVariable Long id, Model model) {
        HorarioDto horario = horarioService.obtenerPorId(id);
        if (horario == null) {
            return "redirect:/horarios";
        }
        model.addAttribute("horario", horario);
        model.addAttribute("empleados", userService.listarUser().stream()
                .filter(u -> u.getRol() != null && "EMPLEADO".equals(u.getRol().getNombre()))
                .collect(Collectors.toList()));
        return "horario/form";
    }

    @PostMapping("/horarios/save")
    public String guardar(@ModelAttribute HorarioDto horario, RedirectAttributes redirect) {
        if (horario.getId() == null) {
            horarioService.crearHorario(horario);
        } else {
            horarioService.actualizarHorario(horario.getId(), horario);
        }
        return "redirect:/horarios";
    }

    @PostMapping("/horarios/delete/{id}")
    public String eliminar(@PathVariable Long id) {
        horarioService.eliminarHorario(id);
        return "redirect:/horarios";
    }

    @PostMapping("/api/horarios")
    @ResponseBody
    public ResponseEntity<HorarioDto> crearHorario(@RequestBody HorarioDto dto) {
        return ResponseEntity.ok(horarioService.crearHorario(dto));
    }

    @GetMapping("/api/horarios")
    @ResponseBody
    public ResponseEntity<List<HorarioDto>> listarHorarioApi() {
        return ResponseEntity.ok(horarioService.listarHorario());
    }

    @GetMapping("/api/horarios/{id}")
    @ResponseBody
    public ResponseEntity<HorarioDto> obtenerPorId(@PathVariable Long id) {
        HorarioDto horario = horarioService.obtenerPorId(id);
        return ResponseEntity.ok(horario);
    }

    @PutMapping("/api/horarios/{id}")
    @ResponseBody
    public ResponseEntity<HorarioDto> actualizarHorario(@PathVariable Long id, @RequestBody HorarioDto dto) {
        return ResponseEntity.ok(horarioService.actualizarHorario(id, dto));
    }

    @DeleteMapping("/api/horarios/{id}")
    @ResponseBody
    public ResponseEntity<Boolean> eliminarHorario(@PathVariable Long id) {
        boolean eliminado = horarioService.eliminarHorario(id);
        return ResponseEntity.ok(eliminado);
    }
}
