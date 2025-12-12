package com.Ros.exe.Controller;

import com.Ros.exe.DTO.DetallePedidoDto;
import com.Ros.exe.Service.DetallePedidoService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/detalles-pedido")
public class DetallePedidoController {

    @Autowired
    private DetallePedidoService detallePedidoService;

    @PostMapping
    public ResponseEntity<DetallePedidoDto> crearDetallePedido(@RequestBody DetallePedidoDto dto) {
        return ResponseEntity.ok(detallePedidoService.crearDetallePedido(dto));
    }

    @GetMapping
    public ResponseEntity<List<DetallePedidoDto>> listarDetallePedido() {
        return ResponseEntity.ok(detallePedidoService.listarDetallePedido());
    }

    @GetMapping("/{id}")
    public ResponseEntity<DetallePedidoDto> obtenerPorId(@PathVariable Long id) {
        DetallePedidoDto detalle = detallePedidoService.obtenerPorId(id);
        return ResponseEntity.ok(detalle);
    }

    @PutMapping("/{id}")
    public ResponseEntity<DetallePedidoDto> actualizarDetallePedido(@PathVariable Long id, @RequestBody DetallePedidoDto dto) {
        return ResponseEntity.ok(detallePedidoService.actualizarDetallePedido(id, dto));
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Boolean> eliminarDetallePedido(@PathVariable Long id) {
        boolean eliminado = detallePedidoService.eliminarDetallePedido(id);
        return ResponseEntity.ok(eliminado);
    }
}
