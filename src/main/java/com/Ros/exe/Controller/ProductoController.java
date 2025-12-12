package com.Ros.exe.Controller;

import com.Ros.exe.DTO.ProductoDto;
import com.Ros.exe.Service.ProductoService;
import com.Ros.exe.Service.CategoriaService;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import java.util.List;
import java.util.stream.Collectors;

@Controller
public class ProductoController {

    @Autowired
    private ProductoService productoService;

    @Autowired
    private CategoriaService categoriaService;

    @Autowired
    private ModelMapper modelMapper;

    // Vistas Web
    @GetMapping("/productos")
    public String listar(@RequestParam(required = false) String nombre,
                        @RequestParam(required = false) Long categoriaId,
                        @RequestParam(required = false) Double precioMin,
                        @RequestParam(required = false) Double precioMax,
                        // @RequestParam(required = false) Boolean disponible,
                        Model model) {
        List<ProductoDto> productos = productoService.listarProducto();
        
        // Filtrar por nombre
        if (nombre != null && !nombre.isEmpty()) {
            productos = productos.stream()
                .filter(p -> p.getNombre() != null && p.getNombre().toLowerCase().contains(nombre.toLowerCase()))
                .collect(Collectors.toList());
        }
        
        // Filtrar por categoría
        if (categoriaId != null) {
            productos = productos.stream()
                .filter(p -> p.getCategoriaId() != null && p.getCategoriaId().equals(categoriaId))
                .collect(Collectors.toList());
        }
        
        // Filtrar por precio mínimo
        if (precioMin != null) {
            productos = productos.stream()
                .filter(p -> p.getPrecio() != null && p.getPrecio() >= precioMin)
                .collect(Collectors.toList());
        }
        
        // Filtrar por precio máximo
        if (precioMax != null) {
            productos = productos.stream()
                .filter(p -> p.getPrecio() != null && p.getPrecio() <= precioMax)
                .collect(Collectors.toList());
        }
        
        // Filtrar por disponibilidad - removido temporalmente
        // if (disponible != null) {
        //     productos = productos.stream()
        //         .filter(p -> p.getDisponible() == disponible)
        //         .collect(Collectors.toList());
        // }
        
        model.addAttribute("productos", productos);
        model.addAttribute("categorias", categoriaService.listarCategoria());
        model.addAttribute("nombreFiltro", nombre);
        model.addAttribute("categoriaIdFiltro", categoriaId);
        model.addAttribute("precioMinFiltro", precioMin);
        model.addAttribute("precioMaxFiltro", precioMax);
        // model.addAttribute("disponibleFiltro", disponible);
        return "producto/list";
    }

    @GetMapping("/productos/new")
    public String nuevo(Model model) {
        model.addAttribute("producto", new ProductoDto());
        model.addAttribute("categorias", categoriaService.listarCategoria());
        return "producto/form";
    }

    @GetMapping("/productos/edit/{id}")
    public String editar(@PathVariable Long id, Model model) {
        ProductoDto producto = productoService.obtenerProductoPorId(id);
        if (producto == null) {
            return "redirect:/productos";
        }
        model.addAttribute("producto", producto);
        model.addAttribute("categorias", categoriaService.listarCategoria());
        return "producto/form";
    }

    @PostMapping("/productos/save")
    public String guardar(@ModelAttribute ProductoDto producto, RedirectAttributes redirect) {
        try {
            if (producto.getIdProducto() == null) {
                productoService.crearProducto(producto);
                redirect.addFlashAttribute("success", "Producto creado exitosamente");
            } else {
                productoService.actualizarProducto(producto.getIdProducto(), producto);
                redirect.addFlashAttribute("success", "Producto actualizado exitosamente");
            }
        } catch (Exception e) {
            redirect.addFlashAttribute("error", "Error al guardar producto: " + e.getMessage());
        }
        return "redirect:/productos";
    }

    @GetMapping("/productos/{id}")
    public String ver(@PathVariable Long id, Model model) {
        ProductoDto producto = productoService.obtenerProductoPorId(id);
        if (producto == null) {
            return "redirect:/productos";
        }
        model.addAttribute("producto", producto);
        return "producto/view";
    }

    @PostMapping("/productos/delete/{id}")
    public String eliminar(@PathVariable Long id, RedirectAttributes redirect) {
        try {
            productoService.eliminarProducto(id);
            redirect.addFlashAttribute("success", "Producto eliminado exitosamente");
        } catch (Exception e) {
            redirect.addFlashAttribute("error", "Error al eliminar producto: " + e.getMessage());
        }
        return "redirect:/productos";
    }

    // API REST
    @PostMapping("/api/productos")
    @ResponseBody
    public ResponseEntity<ProductoDto> crearProducto(@RequestBody ProductoDto dto) {
        ProductoDto creado = productoService.crearProducto(dto);
        return ResponseEntity.ok(modelMapper.map(creado, ProductoDto.class));
    }

    @GetMapping("/api/productos")
    @ResponseBody
    public ResponseEntity<List<ProductoDto>> listarProductos() {
        List<ProductoDto> productos = productoService.listarProducto()
                .stream()
                .map(p -> modelMapper.map(p, ProductoDto.class))
                .collect(Collectors.toList());
        return ResponseEntity.ok(productos);
    }

    @GetMapping("/api/productos/{id}")
    @ResponseBody
    public ResponseEntity<ProductoDto> obtenerProducto(@PathVariable Long id) {
        ProductoDto dto = productoService.obtenerProductoPorId(id);
        if (dto == null) {
            return ResponseEntity.notFound().build();
        }
        return ResponseEntity.ok(dto);
    }

    @PutMapping("/api/productos/{id}")
    @ResponseBody
    public ResponseEntity<ProductoDto> actualizarProducto(@PathVariable Long id, @RequestBody ProductoDto dto) {
        ProductoDto actualizado = productoService.actualizarProducto(id, dto);
        if (actualizado == null) {
            return ResponseEntity.notFound().build();
        }
        return ResponseEntity.ok(actualizado);
    }

    @DeleteMapping("/api/productos/{id}")
    @ResponseBody
    public ResponseEntity<Void> eliminarProducto(@PathVariable Long id) {
        productoService.eliminarProducto(id);
        return ResponseEntity.noContent().build();
    }

}
