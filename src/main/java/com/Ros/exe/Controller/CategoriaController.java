package com.Ros.exe.Controller;

import com.Ros.exe.DTO.CategoriaDto;
import com.Ros.exe.Service.CategoriaService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import java.util.List;

@Controller
public class CategoriaController {

    @Autowired
    private CategoriaService categoriaService;

    // Vistas Web
    @GetMapping("/categorias")
    public String listar(Model model) {
        model.addAttribute("categorias", categoriaService.listarCategoria());
        return "categoria/list";
    }

    @GetMapping("/categorias/new")
    public String nuevo(Model model) {
        model.addAttribute("categoria", new CategoriaDto());
        return "categoria/form";
    }

    @GetMapping("/categorias/edit/{id}")
    public String editar(@PathVariable Long id, Model model) {
        CategoriaDto categoria = categoriaService.obtenerPorId(id);
        if (categoria == null) {
            return "redirect:/categorias";
        }
        model.addAttribute("categoria", categoria);
        return "categoria/form";
    }

    @PostMapping("/categorias/save")
    public String guardar(@ModelAttribute CategoriaDto categoria, RedirectAttributes redirect) {
        if (categoria.getIdCategoria() == null) {
            categoriaService.crearCategoria(categoria);
            redirect.addFlashAttribute("success", "Categoría creada exitosamente");
        } else {
            categoriaService.actualizarCategoria(categoria.getIdCategoria(), categoria);
            redirect.addFlashAttribute("success", "Categoría actualizada exitosamente");
        }
        return "redirect:/categorias";
    }

    @PostMapping("/categorias/delete/{id}")
    public String eliminar(@PathVariable Long id, RedirectAttributes redirect) {
        categoriaService.eliminarCategoria(id);
        redirect.addFlashAttribute("success", "Categoría eliminada exitosamente");
        return "redirect:/categorias";
    }

    // API REST
    @PostMapping("/api/categorias")
    @ResponseBody
    public ResponseEntity<CategoriaDto> crearCategoria(@RequestBody CategoriaDto dto) {
        CategoriaDto nuevaCategoria = categoriaService.crearCategoria(dto);
        if (nuevaCategoria == null) {
            return ResponseEntity.status(HttpStatus.BAD_REQUEST).build();
        }
        return ResponseEntity.ok(nuevaCategoria);
    }

    @GetMapping("/api/categorias")
    @ResponseBody
    public ResponseEntity<List<CategoriaDto>> listarCategoria() {
        List<CategoriaDto> categorias = categoriaService.listarCategoria();
        if (categorias == null || categorias.isEmpty()) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.ok(categorias);
    }

    @GetMapping("/api/categorias/{id}")
    @ResponseBody
    public ResponseEntity<CategoriaDto> obtenerPorId(@PathVariable Long id) {
        CategoriaDto categoria = categoriaService.obtenerPorId(id);
        if (categoria == null) {
            return ResponseEntity.status(HttpStatus.NOT_FOUND).build();
        }
        return ResponseEntity.ok(categoria);
    }

    @PutMapping("/api/categorias/{id}")
    @ResponseBody
    public ResponseEntity<CategoriaDto> actualizarCategoria(@PathVariable Long id, @RequestBody CategoriaDto dto) {
        CategoriaDto actualizada = categoriaService.actualizarCategoria(id, dto);
        if (actualizada == null) {
            return ResponseEntity.status(HttpStatus.NOT_FOUND).build();
        }
        return ResponseEntity.ok(actualizada);
    }

    @DeleteMapping("/api/categorias/{id}")
    @ResponseBody
    public ResponseEntity<Boolean> eliminarCategoria(@PathVariable Long id) {
        boolean eliminado = categoriaService.eliminarCategoria(id);
        if (!eliminado) {
            return ResponseEntity.status(HttpStatus.NOT_FOUND).body(false);
        }
        return ResponseEntity.ok(true);
    }
}
