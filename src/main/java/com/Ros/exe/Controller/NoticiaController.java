package com.Ros.exe.Controller;

import com.Ros.exe.DTO.NoticiaDto;
import com.Ros.exe.Service.NoticiaService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;
import java.util.List;

@Controller
public class NoticiaController {

    @Autowired
    private NoticiaService noticiaService;

    @GetMapping("/noticias")
    public String listar(Model model) {
        model.addAttribute("noticias", noticiaService.listarNoticias());
        return "noticia/list";
    }

    @GetMapping("/noticias/new")
    public String nuevo(Model model) {
        model.addAttribute("noticia", new NoticiaDto());
        return "noticia/form";
    }

    @GetMapping("/noticias/edit/{id}")
    public String editar(@PathVariable Long id, Model model) {
        NoticiaDto noticia = noticiaService.listarNoticias().stream()
                .filter(n -> n.getId().equals(id))
                .findFirst()
                .orElse(null);
        if (noticia == null) {
            return "redirect:/noticias";
        }
        model.addAttribute("noticia", noticia);
        return "noticia/form";
    }

    @PostMapping("/noticias/save")
    public String guardar(@ModelAttribute NoticiaDto noticia, RedirectAttributes redirect) {
        try {
            // Validar URL de imagen si se proporciona
            if (noticia.getImagen() != null && !noticia.getImagen().trim().isEmpty()) {
                String imagen = noticia.getImagen().trim();
                if (!imagen.startsWith("/") && !imagen.startsWith("http")) {
                    imagen = "/images/noticias/" + imagen;
                    noticia.setImagen(imagen);
                }
            }
            
            if (noticia.getId() == null) {
                noticiaService.crearNoticia(noticia);
                redirect.addFlashAttribute("success", "Noticia creada exitosamente");
            } else {
                noticiaService.actualizarNoticia(noticia.getId(), noticia);
                redirect.addFlashAttribute("success", "Noticia actualizada exitosamente");
            }
        } catch (Exception e) {
            redirect.addFlashAttribute("error", "Error al guardar noticia: " + e.getMessage());
        }
        return "redirect:/noticias";
    }

    @PostMapping("/noticias/delete/{id}")
    public String eliminar(@PathVariable Long id, RedirectAttributes redirect) {
        noticiaService.eliminarNoticia(id);
        redirect.addFlashAttribute("success", "Noticia eliminada exitosamente");
        return "redirect:/noticias";
    }

    @PostMapping("/api/noticia")
    @ResponseBody
    public ResponseEntity<NoticiaDto> crearNoticia(@RequestBody NoticiaDto noticiaDto) {
        NoticiaDto nuevaNoticia = noticiaService.crearNoticia(noticiaDto);
        return ResponseEntity.ok(nuevaNoticia);
    }

    @GetMapping("/api/noticia")
    @ResponseBody
    public ResponseEntity<List<NoticiaDto>> listarNoticiasApi() {
        List<NoticiaDto> noticias = noticiaService.listarNoticias();
        return ResponseEntity.ok(noticias);
    }

    @PutMapping("/api/noticia/{idNoticia}")
    @ResponseBody
    public ResponseEntity<NoticiaDto> actualizarNoticiaApi(@PathVariable Long idNoticia, @RequestBody NoticiaDto noticiaDto) {
        NoticiaDto noticiaActualizada = noticiaService.actualizarNoticia(idNoticia, noticiaDto);

        if (noticiaActualizada == null) {
            return ResponseEntity.notFound().build();
        }

        return ResponseEntity.ok(noticiaActualizada);
    }

    @DeleteMapping("/api/noticia/{idNoticia}")
    @ResponseBody
    public ResponseEntity<Void> eliminarNoticiaApi(@PathVariable Long idNoticia) {
        boolean eliminado = noticiaService.eliminarNoticia(idNoticia);

        if (!eliminado) {
            return ResponseEntity.notFound().build();
        }

        return ResponseEntity.noContent().build();
    }
}
