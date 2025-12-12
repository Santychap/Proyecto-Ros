package com.Ros.exe.Controller;

import com.Ros.exe.DTO.PromocionDto;
import com.Ros.exe.Service.PromocionService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import java.util.List;

@Controller
public class PromocionController {

    @Autowired
    private PromocionService promocionService;

    @GetMapping("/promociones")
    public String listar(Model model) {
        model.addAttribute("promociones", promocionService.listarPromociones());
        return "promocion/list";
    }

    @GetMapping("/promociones/new")
    public String nuevo(Model model) {
        model.addAttribute("promocion", new PromocionDto());
        return "promocion/form";
    }

    @GetMapping("/promociones/edit/{id}")
    public String editar(@PathVariable Long id, Model model) {
        PromocionDto promocion = promocionService.listarPromociones().stream()
                .filter(p -> p.getIdPromocion().equals(id))
                .findFirst()
                .orElse(null);
        if (promocion == null) {
            return "redirect:/promociones";
        }
        model.addAttribute("promocion", promocion);
        return "promocion/form";
    }

    @PostMapping("/promociones/delete/{id}")
    public String eliminar(@PathVariable Long id, RedirectAttributes redirect) {
        promocionService.eliminarPromocion(id);
        redirect.addFlashAttribute("success", "Promoción eliminada exitosamente");
        return "redirect:/promociones";
    }

    @PostMapping("/promociones/save")
    public String guardar(@ModelAttribute PromocionDto promocion, RedirectAttributes redirect) {
        try {
            // Validar URL de imagen si se proporciona
            if (promocion.getImagenUrl() != null && !promocion.getImagenUrl().trim().isEmpty()) {
                String imagen = promocion.getImagenUrl().trim();
                if (!imagen.startsWith("/") && !imagen.startsWith("http")) {
                    imagen = "/images/promociones/" + imagen;
                    promocion.setImagenUrl(imagen);
                }
            }
            
            if (promocion.getIdPromocion() == null) {
                promocionService.crearPromocion(promocion);
                redirect.addFlashAttribute("success", "Promoción creada exitosamente");
            } else {
                promocionService.actualizarPromocion(promocion.getIdPromocion(), promocion);
                redirect.addFlashAttribute("success", "Promoción actualizada exitosamente");
            }
        } catch (Exception e) {
            redirect.addFlashAttribute("error", "Error al guardar promoción: " + e.getMessage());
        }
        return "redirect:/promociones";
    }

    @PostMapping("/api/promociones")
    @ResponseBody
    public ResponseEntity<PromocionDto> crearPromocion(@RequestBody PromocionDto promocionDto) {
        return ResponseEntity.ok(promocionService.crearPromocion(promocionDto));
    }

    @GetMapping("/api/promociones")
    @ResponseBody
    public ResponseEntity<List<PromocionDto>> listarPromociones() {
        return ResponseEntity.ok(promocionService.listarPromociones());
    }

    @PutMapping("/api/promociones/{idPromocion}")
    @ResponseBody
    public ResponseEntity<PromocionDto> actualizarPromocion(@PathVariable Long idPromocion, @RequestBody PromocionDto promocionDto) {
        PromocionDto existente = promocionService.actualizarPromocion(idPromocion, promocionDto);
        if (existente == null) {
            return ResponseEntity.notFound().build();
        }
        return ResponseEntity.ok(existente);
    }

    @DeleteMapping("/api/promociones/{idPromocion}")
    @ResponseBody
    public ResponseEntity<Void> eliminarPromocion(@PathVariable Long idPromocion) {
        try {
            promocionService.eliminarPromocion(idPromocion);
            return ResponseEntity.noContent().build();
        } catch (RuntimeException e) {
            return ResponseEntity.notFound().build();
        }
    }
}
