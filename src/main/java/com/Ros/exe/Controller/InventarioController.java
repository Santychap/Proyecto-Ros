package com.Ros.exe.Controller;

import com.Ros.exe.DTO.InventarioDto;
import com.Ros.exe.Service.InventarioService;
import com.Ros.exe.Service.ProductoService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@Controller
public class InventarioController {

    @Autowired
    private InventarioService inventarioService;
    
    @Autowired
    private ProductoService productoService;

    @GetMapping("/inventario")
    public String listar(Model model) {
        model.addAttribute("inventario", inventarioService.listarInventario());
        return "inventario/list";
    }

    @GetMapping("/inventario/new")
    public String nuevo(Model model) {
        model.addAttribute("inventario", new InventarioDto());
        model.addAttribute("productos", productoService.listarProducto());
        return "inventario/form";
    }

    @GetMapping("/inventario/edit/{id}")
    public String editar(@PathVariable Long id, Model model) {
        InventarioDto inventario = inventarioService.obtenerPorId(id);
        if (inventario == null) {
            return "redirect:/inventario";
        }
        model.addAttribute("inventario", inventario);
        model.addAttribute("productos", productoService.listarProducto());
        return "inventario/form";
    }

    @PostMapping("/inventario/save")
    public String guardar(@ModelAttribute InventarioDto inventario) {
        if (inventario.getId() == null) {
            inventarioService.crearInventario(inventario);
        } else {
            inventarioService.actualizarInventario(inventario.getId(), inventario);
        }
        return "redirect:/inventario";
    }

    @PostMapping("/inventario/delete/{id}")
    public String eliminar(@PathVariable Long id) {
        inventarioService.eliminarInventario(id);
        return "redirect:/inventario";
    }

    @PostMapping("/api/inventarios")
    @ResponseBody
    public ResponseEntity<InventarioDto> crearInventario(@RequestBody InventarioDto dto) {
        return ResponseEntity.ok(inventarioService.crearInventario(dto));
    }

    @GetMapping("/api/inventarios")
    @ResponseBody
    public ResponseEntity<List<InventarioDto>> listarInventarioApi() {
        return ResponseEntity.ok(inventarioService.listarInventario());
    }

    @GetMapping("/api/inventarios/{id}")
    @ResponseBody
    public ResponseEntity<InventarioDto> obtenerPorId(@PathVariable Long id) {
        InventarioDto inventario = inventarioService.obtenerPorId(id);
        return ResponseEntity.ok(inventario);
    }

    @PutMapping("/api/inventarios/{id}")
    @ResponseBody
    public ResponseEntity<InventarioDto> actualizarInventario(@PathVariable Long id, @RequestBody InventarioDto dto) {
        return ResponseEntity.ok(inventarioService.actualizarInventario(id, dto));
    }

    @DeleteMapping("/api/inventarios/{id}")
    @ResponseBody
    public ResponseEntity<Boolean> eliminarInventario(@PathVariable Long id) {
        boolean eliminado = inventarioService.eliminarInventario(id);
        return ResponseEntity.ok(eliminado);
    }
}
