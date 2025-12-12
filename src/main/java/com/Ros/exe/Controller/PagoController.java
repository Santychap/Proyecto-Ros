package com.Ros.exe.Controller;

import com.Ros.exe.DTO.PagoDto;
import com.Ros.exe.Service.PagoService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import java.util.List;

@Controller
public class PagoController {

    @Autowired
    private PagoService pagoService;

    @GetMapping("/pagos")
    public String listar(Model model) {
        model.addAttribute("pagos", pagoService.listarPago());
        return "pago/list";
    }

    @PostMapping("/api/pago")
    @ResponseBody
    public ResponseEntity<PagoDto> crearPago(@RequestBody PagoDto pagoDto) {
        PagoDto nuevoPago = pagoService.crearPago(pagoDto);
        return ResponseEntity.ok(nuevoPago);
    }

    @GetMapping("/api/pago")
    @ResponseBody
    public ResponseEntity<List<PagoDto>> listarPagoApi() {
        List<PagoDto> pagos = pagoService.listarPago();
        return ResponseEntity.ok(pagos);
    }

    @PutMapping("/api/pago/{idPago}")
    @ResponseBody
    public ResponseEntity<PagoDto> actualizarPago(@PathVariable Long idPago, @RequestBody PagoDto pagoDto) {
        PagoDto pagoActualizado = pagoService.actualizarPago(idPago, pagoDto);

        if (pagoActualizado == null) {
            return ResponseEntity.notFound().build();
        }

        return ResponseEntity.ok(pagoActualizado);
    }

    @DeleteMapping("/api/pago/{idPago}")
    @ResponseBody
    public ResponseEntity<Void> eliminarPago(@PathVariable Long idPago) {
        boolean eliminado = pagoService.eliminarPago(idPago);

        if (!eliminado) {
            return ResponseEntity.notFound().build();
        }

        return ResponseEntity.noContent().build();
    }
}
