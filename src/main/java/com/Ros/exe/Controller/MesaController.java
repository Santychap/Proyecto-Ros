package com.Ros.exe.Controller;

import com.Ros.exe.DTO.MesaDto;
import com.Ros.exe.Service.MesaService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;
import java.util.List;

@Controller
public class MesaController {

    @Autowired
    private MesaService mesaService;

    // Vistas Web
    @GetMapping("/mesas")
    public String listar(Model model) {
        model.addAttribute("mesas", mesaService.listarMesa());
        return "mesa/list";
    }

    @GetMapping("/mesas/new")
    public String nuevo(Model model) {
        model.addAttribute("mesa", new MesaDto());
        return "mesa/form";
    }

    @GetMapping("/mesas/edit/{id}")
    public String editar(@PathVariable Long id, Model model) {
        try {
            MesaDto mesa = mesaService.listarMesa().stream()
                    .filter(m -> m.getIdMesa().equals(id))
                    .findFirst()
                    .orElse(null);
            if (mesa == null) {
                return "redirect:/mesas";
            }
            model.addAttribute("mesa", mesa);
            return "mesa/form";
        } catch (Exception e) {
            return "redirect:/mesas";
        }
    }

    @PostMapping("/mesas/save")
    public String guardar(@ModelAttribute MesaDto mesa, RedirectAttributes redirect) {
        if (mesa.getIdMesa() == null) {
            mesaService.crearMesa(mesa);
        } else {
            mesaService.actualizarMesa(mesa.getIdMesa(), mesa);
        }
        return "redirect:/mesas";
    }

    @PostMapping("/mesas/delete/{id}")
    public String eliminar(@PathVariable Long id, RedirectAttributes redirect) {
        mesaService.eliminarMesa(id);
        redirect.addFlashAttribute("success", "Mesa eliminada exitosamente");
        return "redirect:/mesas";
    }

    // API REST

    @PostMapping("/api/mesa")
    @ResponseBody
    public ResponseEntity<MesaDto> crearMesa(@RequestBody MesaDto mesaDto) {
        MesaDto nuevaMesa = mesaService.crearMesa(mesaDto);
        return ResponseEntity.ok(nuevaMesa);
    }

    @GetMapping("/api/mesa")
    @ResponseBody
    public ResponseEntity<List<MesaDto>> listarMesas() {
        List<MesaDto> mesas = mesaService.listarMesa();
        return ResponseEntity.ok(mesas);
    }

    @PutMapping("/api/mesa/{idMesa}")
    @ResponseBody
    public ResponseEntity<MesaDto> actualizarMesa(@PathVariable Long idMesa, @RequestBody MesaDto mesaDto) {
        MesaDto mesaActualizada = mesaService.actualizarMesa(idMesa, mesaDto);

        if (mesaActualizada == null) {
            return ResponseEntity.notFound().build();
        }

        return ResponseEntity.ok(mesaActualizada);
    }

    @DeleteMapping("/api/mesa/{idMesa}")
    @ResponseBody
    public ResponseEntity<Void> eliminarMesa(@PathVariable Long idMesa) {
        boolean eliminado = mesaService.eliminarMesa(idMesa);

        if (!eliminado) {
            return ResponseEntity.notFound().build();
        }

        return ResponseEntity.noContent().build();
    }
}
