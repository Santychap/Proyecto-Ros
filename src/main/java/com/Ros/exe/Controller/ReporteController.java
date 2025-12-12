package com.Ros.exe.Controller;

import com.Ros.exe.Service.ReporteService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;

import java.time.LocalDate;

@Controller
@RequestMapping("/admin/reportes")
@PreAuthorize("hasRole('ADMINISTRADOR')")
public class ReporteController {

    @Autowired
    private ReporteService reporteService;

    @GetMapping
    public String mostrarReportes(Model model) {
        model.addAttribute("fechaActual", LocalDate.now());
        return "admin/reportes/index";
    }

    // Reportes de Pedidos
    @GetMapping("/pedidos/semanal")
    public ResponseEntity<byte[]> reportePedidosSemanal() {
        byte[] pdf = reporteService.generarReportePedidosSemanal();
        return crearRespuestaPDF(pdf, "reporte-pedidos-semanal.pdf");
    }

    @GetMapping("/pedidos/mensual")
    public ResponseEntity<byte[]> reportePedidosMensual() {
        byte[] pdf = reporteService.generarReportePedidosMensual();
        return crearRespuestaPDF(pdf, "reporte-pedidos-mensual.pdf");
    }

    @GetMapping("/pedidos/anual")
    public ResponseEntity<byte[]> reportePedidosAnual() {
        byte[] pdf = reporteService.generarReportePedidosAnual();
        return crearRespuestaPDF(pdf, "reporte-pedidos-anual.pdf");
    }

    // Reportes de Pagos
    @GetMapping("/pagos/semanal")
    public ResponseEntity<byte[]> reportePagosSemanal() {
        byte[] pdf = reporteService.generarReportePagosSemanal();
        return crearRespuestaPDF(pdf, "reporte-pagos-semanal.pdf");
    }

    @GetMapping("/pagos/mensual")
    public ResponseEntity<byte[]> reportePagosMensual() {
        byte[] pdf = reporteService.generarReportePagosMensual();
        return crearRespuestaPDF(pdf, "reporte-pagos-mensual.pdf");
    }

    @GetMapping("/pagos/anual")
    public ResponseEntity<byte[]> reportePagosAnual() {
        byte[] pdf = reporteService.generarReportePagosAnual();
        return crearRespuestaPDF(pdf, "reporte-pagos-anual.pdf");
    }

    // Reportes de Reservas
    @GetMapping("/reservas/semanal")
    public ResponseEntity<byte[]> reporteReservasSemanal() {
        byte[] pdf = reporteService.generarReporteReservasSemanal();
        return crearRespuestaPDF(pdf, "reporte-reservas-semanal.pdf");
    }

    @GetMapping("/reservas/mensual")
    public ResponseEntity<byte[]> reporteReservasMensual() {
        byte[] pdf = reporteService.generarReporteReservasMensual();
        return crearRespuestaPDF(pdf, "reporte-reservas-mensual.pdf");
    }

    @GetMapping("/reservas/anual")
    public ResponseEntity<byte[]> reporteReservasAnual() {
        byte[] pdf = reporteService.generarReporteReservasAnual();
        return crearRespuestaPDF(pdf, "reporte-reservas-anual.pdf");
    }

    // Reportes de Productos
    @GetMapping("/productos/semanal")
    public ResponseEntity<byte[]> reporteProductosSemanal() {
        byte[] pdf = reporteService.generarReporteProductosSemanal();
        return crearRespuestaPDF(pdf, "reporte-productos-semanal.pdf");
    }

    @GetMapping("/productos/mensual")
    public ResponseEntity<byte[]> reporteProductosMensual() {
        byte[] pdf = reporteService.generarReporteProductosMensual();
        return crearRespuestaPDF(pdf, "reporte-productos-mensual.pdf");
    }

    @GetMapping("/productos/anual")
    public ResponseEntity<byte[]> reporteProductosAnual() {
        byte[] pdf = reporteService.generarReporteProductosAnual();
        return crearRespuestaPDF(pdf, "reporte-productos-anual.pdf");
    }

    // Reportes de Usuarios
    @GetMapping("/usuarios/semanal")
    public ResponseEntity<byte[]> reporteUsuariosSemanal() {
        byte[] pdf = reporteService.generarReporteUsuariosSemanal();
        return crearRespuestaPDF(pdf, "reporte-usuarios-semanal.pdf");
    }

    @GetMapping("/usuarios/mensual")
    public ResponseEntity<byte[]> reporteUsuariosMensual() {
        byte[] pdf = reporteService.generarReporteUsuariosMensual();
        return crearRespuestaPDF(pdf, "reporte-usuarios-mensual.pdf");
    }

    @GetMapping("/usuarios/anual")
    public ResponseEntity<byte[]> reporteUsuariosAnual() {
        byte[] pdf = reporteService.generarReporteUsuariosAnual();
        return crearRespuestaPDF(pdf, "reporte-usuarios-anual.pdf");
    }

    private ResponseEntity<byte[]> crearRespuestaPDF(byte[] pdf, String nombreArchivo) {
        HttpHeaders headers = new HttpHeaders();
        headers.setContentType(MediaType.APPLICATION_PDF);
        headers.setContentDispositionFormData("attachment", nombreArchivo);
        headers.setContentLength(pdf.length);
        
        return ResponseEntity.ok()
                .headers(headers)
                .body(pdf);
    }
}