package com.Ros.exe.Controller;

import com.Ros.exe.DTO.DetallePagoDto;
import com.Ros.exe.Service.DetallePagoService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/detalle-pago")
public class DetallePagoController {

    @Autowired
    private DetallePagoService detallePagoService;

    @PostMapping
    public ResponseEntity<DetallePagoDto> crearDetallePago(@RequestBody DetallePagoDto detallePagoDto) {
        DetallePagoDto dto = detallePagoService.crearDetallePago(detallePagoDto);
        if (dto == null) {
            return ResponseEntity.badRequest().build();
        }
        return ResponseEntity.ok(dto);
    }

    @GetMapping
    public ResponseEntity<List<DetallePagoDto>> listarDetallePago() {
        List<DetallePagoDto> lista = detallePagoService.listarDetallePago();
        if (lista == null || lista.isEmpty()) {
            return ResponseEntity.noContent().build();
        }
        return ResponseEntity.ok(lista);
    }

    @GetMapping("/{id}")
    public ResponseEntity<DetallePagoDto> obtenerPorId(@PathVariable Long id) {
        DetallePagoDto dto = detallePagoService.obtenerPorId(id);
        if (dto == null) {
            return ResponseEntity.notFound().build();
        }
        return ResponseEntity.ok(dto);
    }

    @PutMapping("/{id}")
    public ResponseEntity<DetallePagoDto> actualizarDetallePago(@PathVariable Long id, @RequestBody DetallePagoDto detallePagoDto) {
        DetallePagoDto dto = detallePagoService.actualizarDetallePago(id, detallePagoDto);
        if (dto == null) {
            return ResponseEntity.notFound().build();
        }
        return ResponseEntity.ok(dto);
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> eliminarDetallePago(@PathVariable Long id) {
        boolean eliminado = detallePagoService.eliminarDetallePago(id);
        if (!eliminado) {
            return ResponseEntity.notFound().build();
        }
        return ResponseEntity.noContent().build();
    }
}
